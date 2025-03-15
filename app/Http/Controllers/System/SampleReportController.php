<?php
namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Pack;
use App\Models\ProductDetail;
use App\Models\Sample;
use App\Models\SampleReport;
use App\Models\SampleReportDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Brian2694\Toastr\Facades\Toastr;

use App\Models\SampleApprovalTree;
use App\Models\SampleReviewer;
use App\Models\SampleApprover;

class SampleReportController extends Controller
{
    public function index(SampleReport $SampleReport, Request $request)
    {

        $query = $SampleReport->getSampleReport();

       

        if ($request->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $report = route('sample.report', $row->SampleReportID);
                    $edit   = route('samplereport.edit', $row->SampleReportID);
                    $delete = route('sample.report.delete', $row->SampleReportID);
                    return sampleReportButton($report, $delete, $edit, $row->SampleReportID);
                })
                ->addColumn('product', function ($row) {
                    return $row->sample->product->ProductName ?? 'N/A';
                })
                ->addColumn('SampleReportID', function ($row) {
                    return 'STB/REPORT/' . sprintf('%04d', $row->SampleReportID); 
                })
                ->addColumn('SampleNo', function ($row) {
                    return 'STB/SAMPLE/' . sprintf('%03d', $row->SampleID);
                })
                ->addColumn('condition', function ($row) {
                    return $row->condition->ConditionName ?? 'N/A';
                })
                ->addColumn('batch', function ($row) {
                    return $row->batch->BatchNo ?? 'N/A';
                })
                ->addColumn('sku', function ($row) {
                    $productDetail = ProductDetail::where('SkuID', $row->SkuID)->first();
                    return $productDetail ? ($productDetail->ProductStrength . ' mg') : 'N/A';
                })
                ->addColumn('pack', function ($row) {
                    $pack = Pack::where('PackID', $row->PackID)->first();
                    return $pack ? $pack->PackValue : 'N/A';
                })
                ->addColumn('status', function ($row) {
                    $ProtocolStatus = DB::table('ProtocolStatus')
                        ->where('ProtocolStatusID', $row->SampleReportStatusID)->first();

                    return $ProtocolStatus ? $ProtocolStatus->ProtocolStatus : '';
                })
                ->addColumn('user', function ($row) {
                    return $row->user->name ?? 'N/A';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('system.sample.report.index');
    }

    // public function sampleStore(Request $request, Sample $sample)
    // {
    //     DB::beginTransaction();

    //     try {
    //         $data = $request->all();
    //         unset($data['_token']);
    //         unset($data['SkuID']);
    //         unset($data['PackID']);

    //         foreach ($data as $key => $value) {

    //             if (isset($value['Value'][$key])) {

    //                 if ($key == '0') {
    //                     $SampleReport = SampleReport::create([
    //                         'SampleID' => $sample->SampleID,
    //                         'BatchID' => $value['BatchID'][$key],
    //                         'StudyTypeID' => $value['StudyTypeID'][$key],
    //                         'SkuID' => $value['SkuID'][$key],
    //                         'ConditionID' => $value['ConditionID'][$key],
    //                         'PackID' => $value['PackID'][$key],
    //                         'UserID' => auth()->id(),
    //                         'CreatedAt' => now()
    //                     ]);
    //                 }

    //                 $contains = Str::contains($value['TestID'][0], 't');

    //                 if ($contains) {
    //                     $test = Str::replace('t', '', $value['TestID'][0]);
    //                     $sample = new SampleReportDetail();
    //                     $sample->SampleReportID = $SampleReport->SampleReportID;
    //                     $sample->TestID = $test;
    //                     $sample->Value = isset($value['Value']) ? $value['Value'] : '';
    //                     $sample->Specification = implode(' ', $value['Specification']);
    //                     $sample->CreatedAt = now();
    //                     $sample->save();
    //                 } else {
    //                     $subtest = Str::replace('sub', '', $value['TestID'][0]);
    //                     $sample = new SampleReportDetail();
    //                     $sample->SampleReportID = $SampleReport->SampleReportID;
    //                     $sample->TestID = $subtest;
    //                     $sample->Value = isset($value['Value']) ? $value['Value'] : '';
    //                     $sample->Specification = implode(' ', $value['Specification']);
    //                     $sample->CreatedAt = now();
    //                     $sample->save();
    //                 }
    //             }
    //         }

    //         DB::commit();
    //         return $this->success('sample.report.index', 'Sample report created successfully!');
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return $this->error('sample.report.index', 'Something went wrong!');
    //     }

    // }

    public function report(SampleReport $sampleReport)
    {
        return view('report.sample', compact('sampleReport'));
    }

    public function delete(SampleReport $SampleReport, Request $request)
    {
        SampleReportDetail::where('SampleReportID', $SampleReport->SampleReportID)->delete();
        $SampleReport->delete();
        return $this->success('sample.report.index', 'Sample report deleted successfully!');
    }

    public function sampleStore(Request $request, Sample $sample)
    {


    

        DB::beginTransaction();

        try {
            $data             = $request->except(['_token', 'SkuID', 'PackID','Headline']);
           
            $userId           = auth()->id();
            $currentTimestamp = now();

        

            foreach ($data as $key => $value) {

                // if (! isset($value['Value'][$key])) {
                //     dd($value, $key);
                //     continue;
                // }
               

                if ($key == 0) {
                   
                    $sampleReport = SampleReport::create([
                        'SampleID'    => $sample->SampleID,
                        'BatchID'     => $value['BatchID'][$key],
                        'StudyTypeID' => $value['StudyTypeID'][$key],
                        'SkuID'       => $value['SkuID'][$key],
                        'ConditionID' => $value['ConditionID'][$key],
                        'PackID'      => $value['PackID'][$key],
                        'Headline'    =>  $value['Headline'][$key],
                        'UserID'      => $userId,
                        'CreatedAt'   => $currentTimestamp,
                    ]);
                }
                $testId = $value['TestID'][0];
             
                if (Str::contains($testId, 't')) {
           
                    $testIdData = [
                        'TestID' => Str::replace('t', '', $testId),
                        'SubTestID' => null,
                    ];
                }
        
                if (Str::contains($testId, 'sub')) {
                    $testIdData = [
                        'TestID' => null,
                        'SubTestID' => Str::replace('sub', '', $testId),
                    ];
                  
                }
              
              //  $testIdData = $this->extractTestId($value['TestID'][0]);
              $SampleReportDetail =  SampleReportDetail::create([
                    'SampleReportID' => $sampleReport->SampleReportID,
                    'TestID'         => $testIdData['TestID'],
                    'SubTestID'         => $testIdData['SubTestID'],
                    'Value'          => $value['Value'] ?? '',
                    'Specification'  => $value['Specification'][0],
                    'CreatedAt'      => $currentTimestamp,
                ]);
               // $this->createSampleReportDetail($sampleReport->SampleReportID, $value, $currentTimestamp);
            }

          

            DB::commit();
            return $this->success('sample.report.index', 'Sample report created successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->error('sample.report.index', 'Something went wrong!');
        }
    }

    private function createSampleReportDetail($sampleReportId, $value, $timestamp)
    {

        $testIdData = $this->extractTestId($value['TestID'][0]);

    dd($testIdData);
        SampleReportDetail::create([
            'SampleReportID' => $sampleReportId,
            'TestID'         => $testIdData['TestID'],
            'SubTestID'         => $testIdData['SubTestID'],
            'Value'          => $value['Value'] ?? '',
            'Specification'  => $value['Specification'][0],
            'CreatedAt'      => $timestamp,
        ]);
    }

    private function extractTestId($testId)
    {
       

        if (Str::contains($testId, 't')) {
           
            return [
                'TestID' => Str::replace('t', '', $testId),
                'SubTestID' => null,
            ];
        }

        if (Str::contains($testId, 'sub')) {
            return [
                'TestID' => null,
                'SubTestID' => Str::replace('sub', '', $testId),
            ];
        }

    }

    public function edit(SampleReport $sampleReport)
    {
        $sample = Sample::find($sampleReport->SampleID);

        return view('system.sample.edit', compact('sampleReport', 'sample'));
    }

    public function update(Request $request, string $id)
    {

    
     
        DB::beginTransaction();

        try {
            $data             = $request->except(['_token','Headline', 'ConditionID', 'StudyTypeID', 'BatchID', 'SkuID', 'PackID', '_method','Note']);
            $userId           = auth()->id();
            $currentTimestamp = now();

          

            SampleReportDetail::where('SampleReportID', $id)->delete();

            $firstKey = array_key_first($data);

       
            foreach ($data as $key => $value) {

                if ($key == $firstKey) {

                $sampleReport = SampleReport::updateOrCreate(
                    ['SampleReportID' => $id],
                    [
                        'StudyTypeID' => $value['StudyTypeID'][0],
                        'SkuID'       => $value['SkuID'][0],
                        'ConditionID' => $value['ConditionID'][0],
                        'PackID'      => $value['PackID'][0],
                        'BatchID'     => $value['BatchID'][0],
                        'Note'        =>  serialize($request->Note),
                        'Headline'    => $request->Headline,
                        'UserID'      => $userId,
                        'UpdatedAt'   => $currentTimestamp,
                    ]
                );
            }

                //$this->updateSampleReportDetail($sampleReport->SampleReportID, $value, $currentTimestamp);


                $testId = $value['TestID'][0];
             
                if (Str::contains($testId, 't')) {
           
                    $testIdData = [
                        'TestID' => Str::replace('t', '', $testId),
                        'SubTestID' => null,
                    ];
                }
        
                if (Str::contains($testId, 'sub')) {
                    $testIdData = [
                        'TestID' => null,
                        'SubTestID' => Str::replace('sub', '', $testId),
                    ];
                  
                }
              
              //  $testIdData = $this->extractTestId($value['TestID'][0]);
              $SampleReportDetail =  SampleReportDetail::create([
                    'SampleReportID' => $sampleReport->SampleReportID,
                    'TestID'         => $testIdData['TestID'],
                    'SubTestID'         => $testIdData['SubTestID'],
                    'Value'          => $value['Value'] ?? '',
                    'Specification'  => $value['Specification'][0],
                    'CreatedAt'      => $currentTimestamp,
                ]);
            }

            DB::commit();
            return $this->success('sample.report.index', 'Sample report updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->error('sample.report.index', 'Something went wrong! ' . $e->getMessage());
        }
    }

/**
 * Update or create Sample Report Detail
 */
    private function updateSampleReportDetail($sampleReportId, $value, $timestamp)
    {
        $testId = $this->extractTestId($value['TestID'][0]);

        SampleReportDetail::Create(
            [
                'SampleReportID' => $sampleReportId,
                'TestID'         => $testId,
                'Value'          => $value['Value'] ?? '',
                'Specification'  => $value['Specification'][0] ?? '',
                'UpdatedAt'      => $timestamp,
            ]
        );
    }

    public function approvalSampleStore(Request $request)
    {
        // Validate the request
        $request->validate([
            'sample_report_id' => 'required|integer',
            'ReviewBy'    => 'array|nullable',
            'ReviewBy.*'  => 'integer|exists:users,id',
            'ApprovalBy'  => 'nullable|integer|exists:users,id',
        ]);

        // Process ReviewBy if provided
        if (! empty($request->ReviewBy)) {

            SampleApprovalTree::where('SampleReportID', $request->sample_report_id)
                ->where('SampleApprovalTypeID', 1)
                ->delete();

            SampleReviewer::where('SampleReportID', $request->sample_report_id)
                ->delete();

            foreach ($request->ReviewBy as $userId) {

                SampleApprovalTree::create([
                    'SampleReportID'        => $request->sample_report_id,
                    'SampleApprovalTypeID' => 1,
                    'UserID'                 => $userId,
                    'CreateDate'             => now(),
                ]);

              
            }
        }

        // Process ApprovalBy if provided
        if ($request->ApprovalBy) {

            SampleApprovalTree::where('SampleReportID', $request->sample_report_id)
                ->where('SampleApprovalTypeID', 2)
                ->delete();

            SampleApprover::where('SampleReportID', $request->sample_report_id)
                ->delete();

            SampleApprovalTree::create([
                'SampleReportID'             => $request->sample_report_id,
                'SampleApprovalTypeID' => 2,
                'UserID'                 => $request->ApprovalBy,
                'CreateDate'             => now(),
            ]);

            SampleReport::where('SampleReportID', $request->sample_report_id)
                ->update([
                    'SampleReportStatusID' => 1,
                ]);

           
        }

        // Flash success message
        Toastr::success('Sample Approval created successfully!', 'Success');

        // Redirect back
        return redirect()->back();
    }
    public function getApprovalDetails($id)
    {
        
        $reviewByOne = SampleApprovalTree::where('SampleReportID', $id)
            ->where('SampleApprovalTypeID', 1)
            ->first();

        $reviewByTwo = SampleApprovalTree::where('SampleReportID', $id)
            ->where('SampleApprovalTypeID', 1)
            ->latest('CreateDate')
            ->first();

        $approvalBy = SampleApprovalTree::where('SampleReportID', $id)
            ->where('SampleApprovalTypeID', 2)
            ->first();

        return response()->json([
            'reviewByOne' => $reviewByOne->UserID ?? null,
            'reviewByTwo' => $reviewByTwo->UserID ?? null,
            'approvalBy'  => $approvalBy->UserID ?? null,
        ]);
    }

    public function sampleApprovalDesign(SampleReport $sampleReport, Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();

            $reviewByOne = $request->reviewByOne ? json_decode($request->reviewByOne, true) : null;
            $reviewByTwo = $request->reviewByTwo ? json_decode($request->reviewByTwo, true) : null;
            $approvalBy  = $request->approvalBy ? json_decode($request->approvalBy, true) : null;

            if ($reviewByOne) {
                SampleReviewer::create([
                    'SampleReportID' => $reviewByOne['SampleReportID'],
                    'UserID'     => $reviewByOne['UserID'],
                    'Comment'    => $request->commentOne,
                    'CreateDate' => date('Y-m-d H:i:s'),
                ]);

                SampleReport::where('SampleReportID', $sampleReport->SampleReportID)
                    ->update([
                        'SampleReportStatusID' => 2,
                    ]);
            }

            if ($reviewByTwo) {
                SampleReviewer::create([
                    'SampleReportID' => $sampleReport->SampleReportID,
                    'UserID'     => $reviewByTwo['UserID'],
                    'Comment'    => $request->commentTwo,
                    'CreateDate' => date('Y-m-d H:i:s'),
                ]);

                SampleReport::where('SampleReportID', $sampleReport->SampleReportID)
                    ->update([
                        'SampleReportStatusID' => 3,
                    ]);
            }

            if ($approvalBy) {

                SampleApprover::create([
                    'SampleReportID' => $sampleReport->SampleReportID,
                    'UserID'     => $approvalBy['UserID'],
                    'Comment'    => $request->approvalComment,
                    'CreateDate' => date('Y-m-d H:i:s'),
                ]);

                SampleReport::where('SampleReportID', $sampleReport->SampleReportID)
                    ->update([
                        'SampleReportStatusID' => $request->Approval === 'Approved' ? 4 : 5,
                    ]);
            }

            DB::commit();

            Toastr::success('Sample Report Approval Update successfully!', 'Success');
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Sample Report Approval Update Failed: ' . $e->getMessage());

            Toastr::error('Failed to update Sample Report approval. Please try again.', 'Error');
            return redirect()->back()->withErrors(['error' => 'An error occurred while updating Sample Report approval.']);
        }
    }

}
