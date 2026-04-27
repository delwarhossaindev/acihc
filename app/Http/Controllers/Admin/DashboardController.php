<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BatchDetails;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = now();
        $fromDate = $request->input('from_date', $today->copy()->firstOfMonth()->toDateString());
        $toDate = $request->input('to_date', $today->copy()->endOfMonth()->toDateString());

        $query = $this->withdrawalProductsQuery($fromDate, $toDate)
            ->whereNull('BatchDetails.IsWithdrawal')
            ->orderBy('BatchDetails.WithdrawalDate', 'asc');

        if ($request->ajax()) {
            return DataTables::of($query->get())
                ->addIndexColumn()
                ->addColumn('ProductName', fn ($row) => $row->ProductName ?? 'N/A')
                ->addColumn('Strength', fn ($row) => $row->ProductStrength ?? 'N/A')
                ->addColumn('WithdrawalBy', function ($row) {
                    $withdrawalDate = $row->IsWithdrawalDate ?? '';
                    $withdrawalBy = $row->withdrawalByName ?? 'N/A';
                    return "{$withdrawalBy} ({$withdrawalDate})";
                })
                ->addColumn('Status', fn ($row) => $this->renderStatusBadge($row))
                ->addColumn('action', fn ($row) => $row->IsWithdrawal != 1 ? WithdrawButton($row->BatchDetailsID) : '')
                ->rawColumns(['Status', 'action'])
                ->make(true);
        }

        $withdrawal_products = $query->get();

        return view('admin.dashboard', [
            'withdrawal_products' => $withdrawal_products,
            'from_date'           => $fromDate,
            'to_date'             => $toDate,
        ]);
    }

    public function withdrawnStore(Request $request)
    {
        try {
            $batch = BatchDetails::find($request->batch_detail_id);

            if (! $batch) {
                Toastr::error('Batch not found. Please try again.', 'Error');
                return redirect()->back();
            }

            $batch->update([
                'IsWithdrawalDate' => now(),
                'WithdrawalBy'     => Auth::id(),
                'IsWithdrawal'     => 1,
            ]);

            Toastr::success('Withdrawn successfully!', 'Success');
        } catch (\Throwable $e) {
            Log::error('Withdrawal update failed: ' . $e->getMessage());
            Toastr::error('An error occurred while updating the withdrawn date. Please try again.', 'Error');
        }

        return redirect()->back();
    }

    public function export(Request $request)
    {
        $fromDate = $request->input('from_date', now()->copy()->subMonth()->firstOfMonth()->toDateString());
        $toDate = $request->input('to_date', now()->copy()->endOfMonth()->toDateString());

        $data = $this->withdrawalProductsQuery($fromDate, $toDate)->get();

        $csvHeader = [
            'Product Name',
            'Condition',
            'Batch No',
            'SI Date',
            'Withdrawal Date',
            'Unit Pack',
            'Month',
            'Withdrawal By',
        ];

        $rows = $data->map(fn ($item) => [
            $item->ProductName,
            $item->ConditionName,
            $item->BatchNo,
            $item->SIDate,
            $item->WithdrawalDate,
            $item->PackID,
            $item->Month,
            $item->withdrawalByName,
        ]);

        $callback = function () use ($rows, $csvHeader) {
            echo "\xEF\xBB\xBF";
            $file = fopen('php://output', 'w');
            fputcsv($file, $csvHeader);
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        $filename = 'withdrawals_' . now()->format('Ymd_His') . '.csv';

        return Response::stream($callback, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$filename}",
            'Cache-Control'       => 'no-store, no-cache',
        ]);
    }

    protected function withdrawalProductsQuery(string $fromDate, string $toDate)
    {
        return BatchDetails::query()
            ->leftJoin('Batch', 'BatchDetails.BatchID', '=', 'Batch.BatchID')
            ->leftJoin('users', 'BatchDetails.WithdrawalBy', '=', 'users.id')
            ->leftJoin('Product', 'Batch.ProductID', '=', 'Product.ProductID')
            ->leftJoin('Condition', 'BatchDetails.ConditionID', '=', 'Condition.ConditionID')
            ->leftJoin('ProductDetail', 'Batch.SkuID', '=', 'ProductDetail.SkuID')
            ->select([
                'BatchDetails.*',
                'Batch.BatchName',
                'Batch.BatchNo',
                'Batch.SIDate',
                'Batch.PackID',
                'Batch.SkuID',
                'users.name as withdrawalByName',
                'Product.ProductName',
                'Condition.ConditionName',
                'ProductDetail.ProductStrength',
            ])
            ->whereBetween('BatchDetails.WithdrawalDate', [$fromDate, $toDate]);
    }

    protected function renderStatusBadge($row): string
    {
        if ($row->IsWithdrawal == 1) {
            return '<button class="btn btn-success btn-sm rounded-circle" title="Withdrawn">&nbsp;</button>';
        }

        $today = now();
        $withdrawalDate = Carbon::parse($row->WithdrawalDate);
        $daysUntilWithdrawal = $today->diffInDays($withdrawalDate, false);

        if ($daysUntilWithdrawal >= 10 && $daysUntilWithdrawal <= 15) {
            return '<button class="btn btn-warning btn-sm rounded-circle" title="Upcoming (' . $daysUntilWithdrawal . ' days left)">&nbsp;</button>';
        }

        if ($daysUntilWithdrawal < 0) {
            return '<button class="btn btn-danger btn-sm rounded-circle" title="Long Ahead (' . $daysUntilWithdrawal . ' days left)">&nbsp;</button>';
        }

        return '<button class="btn btn-secondary btn-sm rounded-circle" title="Due or Passed">&nbsp;</button>';
    }
}
