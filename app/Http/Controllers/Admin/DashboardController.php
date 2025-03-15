<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Batch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\ProductDetail;
use Brian2694\Toastr\Facades\Toastr;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = now();
        $first_date_of_current_month = $today->copy()->firstOfMonth()->toDateString();
        $last_date_of_current_month = $today->copy()->endOfMonth()->toDateString();
    
       
        $from_date = $request->input('from_date', $first_date_of_current_month);
        $to_date = $request->input('to_date', $last_date_of_current_month);
    
       
        $withdrawal_products = Batch::whereBetween('SIDate', [$from_date, $to_date])
            ->with('product') 
            ->get();

           

        if ($request->ajax()) {
            $data = $withdrawal_products;
    
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('ProductName', function ($row) {
                    return $row->product->ProductName ?? 'N/A'; 
                })
                ->addColumn('Strength', function ($row) {
                    return ProductDetail::where('SkuID', $row->SkuID)->value('ProductStrength') ?? 'N/A';
                })
                ->addColumn('WithdrawalBy', function ($row) {
                    $WithdrawalDate = $row->IsWithdrawalDate?? '';
                    $WithdrawalBy = $row->withdrawalByName->name ?? '';
                    return  $WithdrawalBy.'('.$WithdrawalDate.')';
                })
                ->addColumn('Status', function ($row) {
                  
                    $today = now();
                    $withdrawalDate = \Carbon\Carbon::parse($row->WithdrawalDate);
                    $todayDate = \Carbon\Carbon::parse($today);
                   // $daysUntilWithdrawal =  $todayDate->diffInDays($row->WithdrawalDate, false);
                    $daysUntilWithdrawal =   $withdrawalDate->diffInDays($today , false);

                    //dd($daysUntilWithdrawal,$withdrawalDate,$today);
                    $daysUntilWithdrawal = abs($daysUntilWithdrawal);

                    if ($row->IsWithdrawal==1) 
                    {
                       return '<button class="btn btn-success btn-sm rounded-circle">&nbsp;</button>';
                        
                    }
                    elseif ($daysUntilWithdrawal >= 10 && $daysUntilWithdrawal <= 15) 
                    {
                        return '<button class="btn btn-warning btn-sm rounded-circle">&nbsp;</button>';
                      
                    }
                     
                    elseif ($daysUntilWithdrawal > 15)
                    {
                        return '<button class="btn btn-danger btn-sm rounded-circle">&nbsp;</button>';
                        
                    } 
                    else
                    {
                        return '<button class="btn btn-secondary btn-sm rounded-circle">&nbsp;</button>';
                       
                    }

                })
                ->addColumn('action', function ($row) {

                    if ($row->IsWithdrawal!=1) 
                    {
                        $BatchID = $row->BatchID;
                        return WithdrawButton( $BatchID);
                    }

                })
            
                ->rawColumns(['ProductName', 'Strength', 'Status','action'])
                ->make(true);
        }
    
        
        return view('admin.dashboard', compact('withdrawal_products', 'from_date', 'to_date'));
    }

    public function withdrawnStore(Request $request)
    {
        try {

            $BatchID = $request->batch_id;
            $Batch = Batch::find($BatchID);
    
            if (!$Batch) {
                Toastr::error('Batch not found. Please try again.', 'Error');
                return redirect()->back();
            }

   
            //$Batch->WithdrawalDate = $request->withdrawnDate;
            $Batch->IsWithdrawalDate = now();
            $Batch->WithdrawalBy = auth()->user()->id;
            $Batch->IsWithdrawal = 1;
            $Batch->save();
    
            Toastr::success('Withdrawn  successfully!', 'Success');
        } 
        catch (\Exception $e) {
            
    
            Toastr::error('An error occurred while updating the withdrawn date. Please try again.', 'Error');
        }
    
        return redirect()->back();
    }
    
    
}
