<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Pack;
use App\Models\ProductDetail;
use App\Models\Sample;
use App\Models\SampleApprovalTree;
use App\Models\SampleApprover;
use App\Models\SampleReport;
use App\Models\SampleReportDetail;
use App\Models\SampleReviewer;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class SampleReportController extends Controller
{
    public function index(SampleReport $SampleReport, Request $request)
    {
        $query = $SampleReport->getSampleReport();

        if ($request->filled('product')) {
            $query->whereHas('sample.product', fn ($q) => $q->where('ProductName', 'like', '%' . $request->product . '%'));
        }

        if ($request->filled('batch')) {
            $query->whereHas('batch', fn ($q) => $q->where('BatchNo', 'like', '%' . $request->batch . '%'));
        }

        if ($request->ajax()) {
            $authUser = Auth::user();

            $studyTypes = DB::table('StudyType')->get(['StudyTypeID', 'StudyTypeName'])->keyBy('StudyTypeID');
            $studyMonths = DB::table('StudyTypeDetail')
                ->get(['StudyTypeID', 'StudyTypeMonth'])
                ->groupBy('StudyTypeID')
                ->map(fn ($rows) => $rows->pluck('StudyTypeMonth')->implode(','));

            $skuStrengths = ProductDetail::pluck('ProductStrength', 'SkuID');
            $packs = Pack::pluck('PackValue', 'PackID');
            $statuses = DB::table('ProtocolStatus')->pluck('ProtocolStatus', 'ProtocolStatusID');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($authUser) {
                    $edit = $authUser?->hasPermission('SampleReportController@edit') ? route('samplereport.edit', $row->SampleReportID) : null;
                    $delete = $authUser?->hasPermission('SampleReportController@delete') ? route('sample.report.delete', $row->SampleReportID) : null;
                    $report = $authUser?->hasPermission('SampleReportController@report') ? route('sample.report', $row->SampleReportID) : null;
                    return sampleReportButton($report, $delete, $edit, $row->SampleReportID);
                })
                ->addColumn('product', fn ($row) => $row->sample->product->ProductName ?? 'N/A')
                ->addColumn('SampleReportNo', fn ($row) => 'STB/REPORT/' . sprintf('%04d', $row->SampleReportID))
                ->addColumn('SampleNo', fn ($row) => 'STB/SAMPLE/' . sprintf('%03d', $row->SampleID))
                ->addColumn('condition', fn ($row) => $row->condition->ConditionName ?? 'N/A')
                ->addColumn('batch', fn ($row) => $row->batch->BatchNo ?? 'N/A')
                ->addColumn('study', function ($row) use ($studyTypes, $studyMonths) {
                    if (! $row->StudyTypeID || ! isset($studyTypes[$row->StudyTypeID])) {
                        return 'N/A';
                    }
                    $months = $studyMonths[$row->StudyTypeID] ?? '';
                    return $studyTypes[$row->StudyTypeID]->StudyTypeName . ' (' . $months . ')';
                })
                ->addColumn('sku', fn ($row) => $skuStrengths[$row->SkuID] ?? 'N/A')
                ->addColumn('pack', fn ($row) => $packs[$row->PackID] ?? 'N/A')
                ->addColumn('status', fn ($row) => $statuses[$row->SampleReportStatusID] ?? '')
                ->addColumn('user', fn ($row) => $row->user->name ?? 'N/A')
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('system.sample.report.index');
    }

    public function report(SampleReport $sampleReport)
    {
        return view('report.sample', compact('sampleReport'));
    }

    public function pdf(SampleReport $sampleReport, Request $request)
    {
        @ini_set('memory_limit', '512M');
        @set_time_limit(300);

        $data = $this->buildSampleReportData($sampleReport);

        $headerHtml = view('system.sample.pdf.header', $data)->render();
        $footerHtml = view('system.sample.pdf.footer', $data)->render();
        $bodyHtml   = view('system.sample.pdf.show', $data)->render();

        // Replace asset URLs in body with absolute filesystem paths so mPDF reads
        // images locally (avoids HTTP self-fetch deadlock on single-threaded `php artisan serve`).
        $publicPath = rtrim(public_path(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $rewriteAssets = function ($html) use ($publicPath) {
            return preg_replace_callback(
                '#(src|href)="' . preg_quote(asset('/'), '#') . '([^"]+)"#i',
                function ($m) use ($publicPath) {
                    $local = $publicPath . str_replace('/', DIRECTORY_SEPARATOR, $m[2]);
                    return $m[1] . '="' . (is_file($local) ? $local : $m[0]) . '"';
                },
                $html
            );
        };
        $bodyHtml   = $rewriteAssets($bodyHtml);
        $headerHtml = $rewriteAssets($headerHtml);

        $tempDir = storage_path('app/mpdf');
        if (! is_dir($tempDir)) {
            @mkdir($tempDir, 0775, true);
        }

        $mpdf = new \Mpdf\Mpdf([
            'mode'                        => 'utf-8',
            'format'                      => 'A4-L',
            'orientation'                 => 'L',
            'margin_left'                 => 10,
            'margin_right'                => 10,
            'margin_top'                  => 30,
            'margin_bottom'               => 16,
            'margin_header'               => 6,
            'margin_footer'               => 6,
            'tempDir'                     => $tempDir,
            'allow_html_optional_endtags' => false,
        ]);

        $mpdf->SetTitle('Sample Report STB/REPORT/' . sprintf('%04d', $sampleReport->SampleReportID));
        $mpdf->SetAuthor('ACI HealthCare Limited');
        $mpdf->showImageErrors      = false;
        $mpdf->shrink_tables_to_fit = 1;
        $mpdf->SetHTMLHeader($headerHtml);
        $mpdf->SetHTMLFooter($footerHtml);

        $prevReporting = error_reporting(E_ERROR | E_PARSE);
        try {
            $mpdf->WriteHTML($bodyHtml);
        } finally {
            error_reporting($prevReporting);
        }

        $filename    = 'STB-REPORT-' . sprintf('%04d', $sampleReport->SampleReportID) . '.pdf';
        $disposition = $request->query('download') ? 'attachment' : 'inline';

        return response($mpdf->Output($filename, 'S'), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => $disposition . '; filename="' . $filename . '"',
        ]);
    }

    private function buildSampleReportData(SampleReport $sampleReport): array
    {
        $protocolId = $sampleReport->sample->protocol->ProtocolID;

        $versionCount = number_format(
            (float) (DB::table('ProtocolVersion')->where('protocol_id', $protocolId)->max('version_no') ?: 1.0),
            2, '.', ''
        );

        $reviewByOne = SampleApprovalTree::where('SampleReportID', $sampleReport->SampleReportID)
            ->where('SampleApprovalTypeID', 1)->first();
        $reviewByOneUser = $reviewByOne ? \App\Models\User::find($reviewByOne->UserID) : null;
        $reviewByOneComment = $reviewByOne
            ? SampleReviewer::where('SampleReportID', $sampleReport->SampleReportID)
                ->where('UserID', $reviewByOne->UserID)->first()
            : null;

        $reviewByTwo = SampleApprovalTree::where('SampleReportID', $sampleReport->SampleReportID)
            ->where('SampleApprovalTypeID', 1)->latest('CreateDate')->first();
        $reviewByTwoUser = $reviewByTwo ? \App\Models\User::find($reviewByTwo->UserID) : null;
        $reviewByTwoComment = $reviewByTwo
            ? SampleReviewer::where('SampleReportID', $sampleReport->SampleReportID)
                ->where('UserID', $reviewByTwo->UserID)->first()
            : null;

        $approvalBy = SampleApprovalTree::where('SampleReportID', $sampleReport->SampleReportID)
            ->where('SampleApprovalTypeID', 2)->first();
        $approvalByUser = $approvalBy ? \App\Models\User::find($approvalBy->UserID) : null;
        $approvalByComment = $approvalBy
            ? SampleApprover::where('SampleReportID', $sampleReport->SampleReportID)
                ->where('UserID', $approvalBy->UserID)->first()
            : null;

        $preparedByUser = $sampleReport->UserID ? \App\Models\User::find($sampleReport->UserID) : null;

        $containerIDs = \App\Models\ProtocolSkuPack::where('ProtocolID', $protocolId)
            ->pluck('ContainerID')->toArray();
        $containers = \App\Models\Container::whereIn('ContainerID', array_unique($containerIDs))
            ->with('packaging')->get();
        $containersCount = 0;
        foreach ($containers as $c) {
            $containersCount += $c->packaging->count();
        }

        $ApiDetailName = [];
        $ApiLot        = [];
        $APIDetailSource = [];
        foreach ($sampleReport->sample->protocol->protocolApiDetails as $api) {
            $apiRow = \App\Models\ApiDetail::where('ApiDetailID', $api->APIDetailID)->first();
            if ($apiRow) {
                $ApiDetailName[]   = $apiRow->ApiDetailName;
                $APIDetailSource[] = $apiRow->APIDetailSource;
            }
            $ApiLot[] = $api->BatchNo;
        }
        $ApiDetailName   = array_values(array_unique(array_filter($ApiDetailName)));
        $ApiLot          = array_values(array_unique(array_filter($ApiLot)));
        $APIDetailSource = array_values(array_unique(array_filter($APIDetailSource)));

        return compact(
            'sampleReport', 'versionCount',
            'reviewByOneUser', 'reviewByOneComment',
            'reviewByTwoUser', 'reviewByTwoComment',
            'approvalByUser', 'approvalByComment',
            'preparedByUser',
            'containers', 'containersCount',
            'ApiDetailName', 'ApiLot', 'APIDetailSource'
        );
    }

    public function delete(SampleReport $SampleReport, Request $request)
    {
        DB::transaction(function () use ($SampleReport) {
            SampleReportDetail::where('SampleReportID', $SampleReport->SampleReportID)->delete();
            $SampleReport->delete();
        });

        return $this->success('sample.report.index', 'Sample report deleted successfully!');
    }

    public function sampleStore(Request $request, Sample $sample)
    {
        try {
            $data = $request->except(['_token', 'SkuID', 'PackID', 'Headline']);
            $userId = Auth::id();
            $now = now();

            DB::transaction(function () use ($data, $sample, $userId, $now) {
                $sampleReport = null;
                $detailRows = [];

                foreach ($data as $key => $value) {
                    if ($key == 0) {
                        $sampleReport = SampleReport::create([
                            'SampleID'    => $sample->SampleID,
                            'BatchID'     => $value['BatchID'][$key] ?? null,
                            'StudyTypeID' => $value['StudyTypeID'][$key] ?? null,
                            'SkuID'       => $value['SkuID'][$key] ?? null,
                            'ConditionID' => $value['ConditionID'][$key] ?? null,
                            'PackID'      => $value['PackID'][$key] ?? null,
                            'Headline'    => $value['Headline'][$key] ?? null,
                            'UserID'      => $userId,
                            'CreatedAt'   => $now,
                        ]);
                    }

                    if (! $sampleReport) {
                        continue;
                    }

                    $testIdData = $this->extractTestId($value['TestID'][0] ?? null);

                    $detailRows[] = [
                        'SampleReportID' => $sampleReport->SampleReportID,
                        'TestID'         => $testIdData['TestID'],
                        'SubTestID'      => $testIdData['SubTestID'],
                        'Value'          => is_string($value['Value'] ?? null) ? $value['Value'] : json_encode($value['Value'] ?? []),
                        'Specification'  => $value['Specification'][0] ?? '',
                        'CreatedAt'      => $now,
                    ];
                }

                if ($detailRows) {
                    SampleReportDetail::insert($detailRows);
                }
            });

            return $this->success('sample.report.index', 'Sample report created successfully!');
        } catch (\Throwable $e) {
            Log::error('SampleReport sampleStore failed: ' . $e->getMessage());
            return $this->error('sample.report.index', 'Something went wrong!');
        }
    }

    public function edit(SampleReport $sampleReport)
    {
        $sample = Sample::find($sampleReport->SampleID);

        return view('system.sample.edit', compact('sampleReport', 'sample'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $data = $request->except(['_token', 'Headline', 'ConditionID', 'StudyTypeID', 'BatchID', 'SkuID', 'PackID', '_method', 'Note']);
            $now = now();

            DB::transaction(function () use ($request, $id, $data, $now) {
                SampleReportDetail::where('SampleReportID', $id)->delete();

                $firstKey = array_key_first($data);
                $sampleReportId = null;

                $detailRows = [];

                foreach ($data as $key => $value) {
                    if ($key === $firstKey) {
                        $sampleReport = SampleReport::updateOrCreate(
                            ['SampleReportID' => $id],
                            [
                                'StudyTypeID' => $request->StudyTypeID ?? $value['StudyTypeID'][0] ?? null,
                                'SkuID'       => $request->SkuID ?? $value['SkuID'][0] ?? null,
                                'ConditionID' => $request->ConditionID ?? $value['ConditionID'][0] ?? null,
                                'PackID'      => $request->PackID ?? $value['PackID'][0] ?? null,
                                'BatchID'     => $request->BatchID ?? $value['BatchID'][0] ?? null,
                                'Note'        => serialize($request->Note),
                                'Headline'    => $request->Headline ?? $value['Headline'][0] ?? null,
                                'UpdatedAt'   => $now,
                            ]
                        );
                        $sampleReportId = $sampleReport->SampleReportID;
                    }

                    if (! $sampleReportId) {
                        continue;
                    }

                    $testIdData = $this->extractTestId($value['TestID'][0] ?? null);

                    $detailRows[] = [
                        'SampleReportID' => $sampleReportId,
                        'TestID'         => $testIdData['TestID'],
                        'SubTestID'      => $testIdData['SubTestID'],
                        'Value'          => is_string($value['Value'] ?? null) ? $value['Value'] : json_encode($value['Value'] ?? []),
                        'Specification'  => $value['Specification'][0] ?? '',
                        'CreatedAt'      => $now,
                    ];
                }

                if ($detailRows) {
                    SampleReportDetail::insert($detailRows);
                }
            });

            return $this->success('sample.report.index', 'Sample report updated successfully!');
        } catch (\Throwable $e) {
            Log::error('SampleReport update failed: ' . $e->getMessage());
            return $this->error('sample.report.index', 'Something went wrong! ' . $e->getMessage());
        }
    }

    public function approvalSampleStore(Request $request)
    {
        $request->validate([
            'sample_report_id' => 'required|integer',
            'ReviewBy'         => 'array|nullable',
            'ReviewBy.*'       => 'integer|exists:users,id',
            'ApprovalBy'       => 'nullable|integer|exists:users,id',
        ]);

        DB::transaction(function () use ($request) {
            if (! empty($request->ReviewBy)) {
                SampleApprovalTree::where('SampleReportID', $request->sample_report_id)
                    ->where('SampleApprovalTypeID', 1)
                    ->delete();

                SampleReviewer::where('SampleReportID', $request->sample_report_id)->delete();

                $now = now();
                $rows = array_map(fn ($userId) => [
                    'SampleReportID'       => $request->sample_report_id,
                    'SampleApprovalTypeID' => 1,
                    'UserID'               => $userId,
                    'CreateDate'           => $now,
                ], $request->ReviewBy);

                SampleApprovalTree::insert($rows);
            }

            if ($request->ApprovalBy) {
                SampleApprovalTree::where('SampleReportID', $request->sample_report_id)
                    ->where('SampleApprovalTypeID', 2)
                    ->delete();

                SampleApprover::where('SampleReportID', $request->sample_report_id)->delete();

                SampleApprovalTree::create([
                    'SampleReportID'       => $request->sample_report_id,
                    'SampleApprovalTypeID' => 2,
                    'UserID'               => $request->ApprovalBy,
                    'CreateDate'           => now(),
                ]);

                SampleReport::where('SampleReportID', $request->sample_report_id)
                    ->update(['SampleReportStatusID' => 1]);
            }
        });

        Toastr::success('Sample Approval created successfully!', 'Success');

        return redirect()->back();
    }

    public function getApprovalDetails($id)
    {
        $rows = SampleApprovalTree::where('SampleReportID', $id)
            ->whereIn('SampleApprovalTypeID', [1, 2])
            ->orderBy('CreateDate')
            ->get(['UserID', 'SampleApprovalTypeID', 'CreateDate']);

        $reviewers = $rows->where('SampleApprovalTypeID', 1)->values();
        $approver = $rows->where('SampleApprovalTypeID', 2)->first();

        return response()->json([
            'reviewByOne' => $reviewers->first()->UserID ?? null,
            'reviewByTwo' => $reviewers->last()->UserID ?? null,
            'approvalBy'  => $approver->UserID ?? null,
        ]);
    }

    public function sampleApprovalDesign(SampleReport $sampleReport, Request $request)
    {
        try {
            DB::transaction(function () use ($sampleReport, $request) {
                $reviewByOne = $request->reviewByOne ? json_decode($request->reviewByOne, true) : null;
                $reviewByTwo = $request->reviewByTwo ? json_decode($request->reviewByTwo, true) : null;
                $approvalBy = $request->approvalBy ? json_decode($request->approvalBy, true) : null;

                if ($reviewByOne) {
                    SampleReviewer::create([
                        'SampleReportID' => $reviewByOne['SampleReportID'],
                        'UserID'         => $reviewByOne['UserID'],
                        'Comment'        => $request->commentOne,
                        'CreateDate'     => now(),
                    ]);

                    SampleReport::where('SampleReportID', $sampleReport->SampleReportID)
                        ->update(['SampleReportStatusID' => 2]);
                }

                if ($reviewByTwo) {
                    SampleReviewer::create([
                        'SampleReportID' => $sampleReport->SampleReportID,
                        'UserID'         => $reviewByTwo['UserID'],
                        'Comment'        => $request->commentTwo,
                        'CreateDate'     => now(),
                    ]);

                    SampleReport::where('SampleReportID', $sampleReport->SampleReportID)
                        ->update(['SampleReportStatusID' => 3]);
                }

                if ($approvalBy) {
                    SampleApprover::create([
                        'SampleReportID' => $sampleReport->SampleReportID,
                        'UserID'         => $approvalBy['UserID'],
                        'Comment'        => $request->approvalComment,
                        'CreateDate'     => now(),
                    ]);

                    SampleReport::where('SampleReportID', $sampleReport->SampleReportID)
                        ->update(['SampleReportStatusID' => $request->Approval === 'Approved' ? 4 : 5]);
                }
            });

            Toastr::success('Sample Report Approval Update successfully!', 'Success');
            return redirect()->back();
        } catch (\Throwable $e) {
            Log::error('Sample Report Approval Update Failed: ' . $e->getMessage());
            Toastr::error('Failed to update Sample Report approval. Please try again.', 'Error');
            return redirect()->back()->withErrors(['error' => 'An error occurred while updating Sample Report approval.']);
        }
    }

    protected function extractTestId(?string $testId): array
    {
        if (! $testId) {
            return ['TestID' => null, 'SubTestID' => null];
        }

        if (Str::startsWith($testId, 'sub')) {
            return ['TestID' => null, 'SubTestID' => Str::replaceFirst('sub', '', $testId)];
        }

        if (Str::startsWith($testId, 't')) {
            return ['TestID' => Str::replaceFirst('t', '', $testId), 'SubTestID' => null];
        }

        return ['TestID' => $testId, 'SubTestID' => null];
    }
}
