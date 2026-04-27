<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProtocolRequest;
use App\Models\Placebo;
use App\Models\Protocol;
use App\Models\ProtocolApproval;
use App\Models\ProtocolBatch;
use App\Models\ProtocolPlaceboDetail;
use App\Models\ProtocolSkuUnitPack;
use App\Models\ProtocolStabilityChamberDesign;
use App\Models\ProtocolSubTest;
use App\Models\ProtocolTest;
use App\Models\ProtocolTestPackBottle;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProtocolController extends Controller
{
    public function index(Protocol $protocol, Request $request)
    {
        if ($request->ajax()) {
            $authUser = Auth::user();

            $versionMap = DB::table('ProtocolVersion')
                ->select('protocol_id', DB::raw('MAX(version_no) as version_no'))
                ->groupBy('protocol_id')
                ->pluck('version_no', 'protocol_id');

            $statusMap = DB::table('ProtocolStatus')
                ->pluck('ProtocolStatus', 'ProtocolStatusID');

            return DataTables::of($protocol->getProtocol())
                ->addIndexColumn()
                ->addColumn('user', fn ($row) => $row->user->name ?? 'N/A')
                ->addColumn('updatedby', fn ($row) => $row->updatedby->name ?? 'N/A')
                ->addColumn('protocolNo', function ($row) use ($versionMap) {
                    $versionNo = $versionMap[$row->ProtocolID] ?? 1.00;
                    $version = number_format((float) $versionNo, 2, '.', '');
                    return 'STB/PROT/' . sprintf('%04d', $row->ProtocolID) . '; Version: ' . $version;
                })
                ->addColumn('Status', fn ($row) => $statusMap[$row->ProtocolStatusID] ?? '')
                ->addColumn('product', function ($row) {
                    $productName = $row->product->ProductName ?? 'N/A';
                    if (! isset($row->product->skus) || $row->product->skus->isEmpty()) {
                        return $productName;
                    }
                    $strengths = $row->product->skus->pluck('ProductStrength')->implode(',');
                    return $productName . '(' . $strengths . ')';
                })
                ->addColumn('action', function ($row) use ($authUser) {
                    $editLink = $authUser?->hasPermission('ProtocolController@edit') ? route('protocol.edit', $row->ProtocolID) : null;
                    $showLink = $authUser?->hasPermission('ProtocolController@show') ? route('protocol.show', $row->ProtocolID) : null;
                    return ProtocolButton($editLink, $showLink, $row->ProtocolID);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('system.protocol.index');
    }

    public function create()
    {
        return view('system.protocol.create');
    }

    public function edit(Protocol $protocol)
    {
        return view('system.protocol.edit', compact('protocol'));
    }

    public function show(Protocol $protocol)
    {
        return view('system.protocol.show', $this->buildShowData($protocol));
    }

    public function pdf(Protocol $protocol, Request $request)
    {
        @ini_set('memory_limit', '512M');
        @set_time_limit(300);

        $data         = $this->buildShowData($protocol);
        $versionCount = number_format(
            (float) (\DB::table('ProtocolVersion')->where('protocol_id', $protocol->ProtocolID)->max('version_no') ?: 1.0),
            2, '.', ''
        );
        $headerData = $data + ['versionCount' => $versionCount];

        $headerHtml = view('system.protocol.pdf.header', $headerData)->render();
        $footerHtml = view('system.protocol.pdf.footer', $data)->render();
        $bodyHtml   = view('system.protocol.pdf.show', $data)->render();

        // Replace asset URLs in body with absolute filesystem paths so mPDF reads
        // images locally (avoids HTTP self-fetch deadlock on single-threaded
        // `php artisan serve`).
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
            'format'                      => 'A4',
            'margin_left'                 => 10,
            'margin_right'                => 10,
            'margin_top'                  => 38,   // room for repeating header
            'margin_bottom'                => 18,   // room for repeating footer
            'margin_header'               => 6,
            'margin_footer'               => 6,
            'tempDir'                     => $tempDir,
            'allow_html_optional_endtags' => false,
        ]);

        $mpdf->SetTitle('Stability Protocol STB/PROT/' . sprintf('%04d', $protocol->ProtocolID));
        $mpdf->SetAuthor('ACI HealthCare Limited');
        $mpdf->showImageErrors      = false;
        $mpdf->shrink_tables_to_fit = 1;
        $mpdf->useSubstitutions     = false;
        $mpdf->SetHTMLHeader($headerHtml);
        $mpdf->SetHTMLFooter($footerHtml);
        $html = $bodyHtml;

        // mPDF still throws PHP 8 "Undefined array key" notices on deeply nested
        // tables. Suppress notice/warning level errors during HTML write only;
        // restore prior level afterwards.
        $prevReporting = error_reporting(E_ERROR | E_PARSE);
        try {
            $mpdf->WriteHTML($html);
        } finally {
            error_reporting($prevReporting);
        }

        $filename = 'STB-PROT-' . sprintf('%04d', $protocol->ProtocolID) . '.pdf';
        $disposition = $request->query('download') ? 'D' : 'I'; // I = inline, D = download

        return response($mpdf->Output($filename, 'S'), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => ($disposition === 'D' ? 'attachment' : 'inline') . '; filename="' . $filename . '"',
        ]);
    }

    private function buildShowData(Protocol $protocol): array
    {
        $protocol->load([
            'tests',
            'protocolSkuUnitPack',
            'subtests',
            'ProtocolTestPackBottle',
            'protocolBatch.batch',
            'statbilityStudy.study.details',
            'packagings',
            'protocolProductDetails',
            'apis.api',
            'sku.perUnit.pack',
            'strengths',
            'product.skus',
            'market',
            'manufacturer.address',
        ]);

        $getData = DB::table('StabilityDesignTitle')->where('ProtocolID', $protocol->ProtocolID)->first();
        $stabilityDesignTitle = isset($getData->Title) ? unserialize($getData->Title) : null;

        return compact('protocol', 'stabilityDesignTitle', 'getData');
    }

    public function store(Protocol $protocol, CreateProtocolRequest $request)
    {
        $protocol = DB::transaction(function () use ($protocol, $request) {
            $protocol = $protocol->storeProtocol($request);

            DB::table('ProtocolVersion')->insert([
                'protocol_id' => $protocol->ProtocolID,
                'version_no'  => 1,
                'created_at'  => now(),
                'created_by'  => Auth::id(),
            ]);

            return $protocol;
        });

        Toastr::success('Protocol created successfully!!', 'Success');

        return redirect()->route('protocol.edit', $protocol->ProtocolID);
    }

    public function updateProtocol(Protocol $protocol, CreateProtocolRequest $request)
    {
        DB::transaction(function () use ($protocol, $request) {
            $currentVersion = DB::table('ProtocolVersion')
                ->where('protocol_id', $protocol->ProtocolID)
                ->lockForUpdate()
                ->max('version_no');

            $increment = $protocol->ProtocolStatusID == 4 ? 1.00 : 0.01;
            $newVersion = $currentVersion ? number_format($currentVersion + $increment, 2, '.', '') : '1.00';

            DB::table('ProtocolVersion')->insert([
                'protocol_id' => $protocol->ProtocolID,
                'version_no'  => $newVersion,
                'created_at'  => now(),
                'created_by'  => Auth::id(),
            ]);

            $protocol->updateProtocol($protocol, $request);
        });

        Toastr::success('Protocol updated successfully!!', 'Success');

        return redirect()->back();
    }

    public function storeProtocolAPIDetail(Protocol $protocol, Request $request)
    {
        $request->validate([
            'ApiID'   => 'required',
            'ExpDate' => 'required',
        ]);

        $protocol->storeProtocolAPIDetail($protocol, $request);

        Toastr::success('API Detail created successfully!', 'Success');

        return redirect()->back();
    }

    public function storeProductDetails(Protocol $protocol, Request $request)
    {
        $protocol->storeProtocolProductDetails($protocol, $request);

        Toastr::success('Product information added successfully!', 'Success');

        return redirect()->back();
    }

    public function storeSkuContainerStore(Protocol $protocol, Request $request)
    {
        $protocol->storeProtocolSkuContainerType($protocol, $request);

        Toastr::success('Packaging profile information added successfully!', 'Success');

        return redirect()->back();
    }

    public function storeProtocolPackagingProfile(Protocol $protocol, Request $request)
    {
        $protocol->storeProtocolPackagingProfile($protocol, $request);

        Toastr::success('Packaging profile information added successfully!', 'Success');

        return redirect()->back();
    }

    public function storeProtocolStabilityStudy(Protocol $protocol, Request $request)
    {
        $protocol->storeProtocolStabilityStudy($protocol, $request);

        Toastr::success('Stability study information added successfully!', 'Success');

        return redirect()->back();
    }

    public function storeProtocolTestDetail(Protocol $protocol, Request $request)
    {
        $data = $request->except(['_token', 'test']);

        DB::transaction(function () use ($protocol, $request, $data) {
            if ($protocol->tests()->exists()) {
                ProtocolTestPackBottle::where('ProtocolID', $protocol->ProtocolID)->delete();
                ProtocolTest::where('ProtocolID', $protocol->ProtocolID)->delete();
                ProtocolSubTest::where('ProtocolID', $protocol->ProtocolID)->delete();
            }

            foreach ($data as $value) {
                $testIdRaw = $value['TestID'][0] ?? null;
                if (! $testIdRaw) {
                    continue;
                }

                if (Str::contains($testIdRaw, 't')) {
                    ProtocolTest::create([
                        'ProtocolID' => $protocol->ProtocolID,
                        'TestID'     => Str::replace('t', '', $testIdRaw),
                        'Value'      => json_encode($value['Value'] ?? null),
                    ]);
                } else {
                    ProtocolSubTest::create([
                        'ProtocolID' => $protocol->ProtocolID,
                        'SubTestID'  => Str::replace('sub', '', $testIdRaw),
                        'Value'      => json_encode($value['Value'] ?? null),
                    ]);
                }
            }

            $tests = (array) $request->test;
            if ($tests) {
                $first = reset($tests);
                $unitPerTest = $request->test['UnitPerTest'] ?? [];
                ProtocolTestPackBottle::create([
                    'ProtocolID'     => $protocol->ProtocolID,
                    'PackID'         => json_encode($first),
                    'NumberOfBottle' => json_encode(array_filter($unitPerTest)),
                ]);
            }
        });

        Toastr::success('Test information saved successfully!', 'Success');

        return redirect()->back();
    }

    public function protocolChamberDesign(Protocol $protocol, Request $request)
    {
        $data = $request->all();
        $title = $data['title'] ?? null;
        $placeboMonth = $data['PlaceboMonth'] ?? null;
        $placeboAdditional = $data['PlaceboAdditional'] ?? null;
        $additionalSample = $data['additionalSample'] ?? null;

        unset($data['_token'], $data['title'], $data['PlaceboMonth'], $data['PlaceboAdditional'], $data['additionalSample']);

        try {
            DB::transaction(function () use ($protocol, $data, $title, $placeboMonth, $placeboAdditional, $additionalSample) {
                $existingPacks = $protocol->protocolSkuUnitPack;
                if ($existingPacks->isNotEmpty()) {
                    $packIds = $existingPacks->pluck('ProtocolSkuUnitPackID');
                    ProtocolStabilityChamberDesign::whereIn('ProtocolSkuUnitPackID', $packIds)->delete();
                    ProtocolSkuUnitPack::where('ProtocolID', $protocol->ProtocolID)->delete();
                    DB::table('StabilityDesignTitle')->where('ProtocolID', $protocol->ProtocolID)->delete();
                    DB::table('PlaceboSkuUnitPack')->where('ProtocolID', $protocol->ProtocolID)->delete();
                }

                foreach ($data as $index => $value) {
                    $studyMonths = $value['StudyTypeMonth'] ?? [];
                    $skuKey = isset($value['SkuID']) ? 'SkuID' : (isset($value['PlaceboSkuID']) ? 'PlaceboSkuID' : null);
                    if (! $skuKey || empty($value[$skuKey])) {
                        continue;
                    }

                    $skuCount = count($value[$skuKey]);
                    $chunkSize = max(1, intval(count($studyMonths) / $skuCount));
                    $finalMonth = array_chunk($studyMonths, $chunkSize);

                    foreach ($value[$skuKey] as $key => $skuID) {
                        $protocol->protocolSkuUnitPack()->create([
                            'SkuID'      => $skuID,
                            'PackID'     => $value['PackID'][$key] ?? null,
                            'Month'      => json_encode($finalMonth[$key] ?? []),
                            'Additional' => $value['Additional'][$key] ?? null,
                        ]);
                    }
                }

                DB::table('StabilityDesignTitle')->insert([
                    'ProtocolID'       => $protocol->ProtocolID,
                    'Title'            => serialize($title),
                    'AdditionalSample' => $additionalSample,
                ]);

                DB::table('PlaceboSkuUnitPack')->insert([
                    'ProtocolID' => $protocol->ProtocolID,
                    'Month'      => json_encode($placeboMonth),
                    'Additional' => $placeboAdditional,
                ]);
            });

            Toastr::success('Stability design added successfully!', 'Success');
        } catch (\Throwable $e) {
            Log::error('protocolChamberDesign failed: ' . $e->getMessage());
            Toastr::error('Failed to add stability design.', 'Error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->back();
    }

    public function protocolPlaceboDesign(Protocol $protocol, Request $request)
    {
        $data = $request->except('_token');

        DB::transaction(function () use ($protocol, $data) {
            if ($protocol->protocolPlacebo()->exists()) {
                $placeboIds = $protocol->protocolPlacebo->pluck('PlaceboID');
                ProtocolPlaceboDetail::whereIn('PlaceboID', $placeboIds)->delete();
                Placebo::where('ProtocolID', $protocol->ProtocolID)->delete();
            }

            foreach ($data as $value) {
                $skuId = $value['SkuID'][0] ?? null;
                if (! $skuId) {
                    continue;
                }

                $placebo = $protocol->protocolPlacebo()->create([
                    'SkuID'  => $skuId,
                    'PackID' => $value['PackID'][0] ?? null,
                ]);

                if (empty($value['StudTypeID']) || empty($value['Unit'][0])) {
                    continue;
                }

                $units = explode(',', $value['Unit'][0]);
                foreach ($value['StudTypeID'] as $index => $studyTypeId) {
                    $placebo->placeboDetails()->create([
                        'StudyTypeID'     => $studyTypeId,
                        'Month'           => $value['Month'][0] ?? null,
                        'Count'           => $units[$index] ?? null,
                        'AditionalSample' => $value['AditionalSample'][0] ?? null,
                    ]);
                }
            }
        });

        Toastr::success('Protocol Placebo created successfully!', 'Success');

        return redirect()->back();
    }

    public function protocolBatchDesign(Protocol $protocol, Request $request)
    {
        $data = $request->except('_token');

        DB::transaction(function () use ($protocol, $data) {
            ProtocolBatch::where('ProtocolID', $protocol->ProtocolID)->delete();

            $batchIds = (array) ($data['BatchID'] ?? []);
            $skuIds = (array) ($data['SkuID'] ?? []);
            $batchNos = (array) ($data['BatchNo'] ?? []);
            $batchSizes = (array) ($data['BatchSize'] ?? []);
            $mfgDates = (array) ($data['MfgDate'] ?? []);
            $siDates = (array) ($data['StabilityInitiationDate'] ?? []);

            $rows = [];
            foreach ($batchIds as $key => $batchId) {
                if (! isset($skuIds[$key])) {
                    continue;
                }

                $rows[] = [
                    'ProtocolID'              => $protocol->ProtocolID,
                    'BatchID'                 => $batchId,
                    'SkuID'                   => $skuIds[$key],
                    'BatchNo'                 => $batchNos[$key] ?? '',
                    'BatchSize'               => $batchSizes[$key] ?? '',
                    'MfgDate'                 => $mfgDates[$key] ?? null,
                    'StabilityInitiationDate' => $siDates[$key] ?? null,
                ];
            }

            if ($rows) {
                ProtocolBatch::insert($rows);
            }
        });

        Toastr::success('Protocol batch created successfully!', 'Success');

        return redirect()->back();
    }

    public function approvalProtocalStore(Request $request)
    {
        $request->validate([
            'protocol_id' => 'required|integer|exists:Protocol,ProtocolID',
            'ReviewBy'    => 'array|nullable',
            'ReviewBy.*'  => 'integer|exists:users,id',
            'ApprovalBy'  => 'nullable|integer|exists:users,id',
        ]);

        $protocolId = (int) $request->protocol_id;
        $reviewerIds = array_values(array_filter((array) $request->ReviewBy));
        $approverId  = $request->ApprovalBy ? (int) $request->ApprovalBy : null;

        DB::transaction(function () use ($protocolId, $reviewerIds, $approverId) {
            $existing = ProtocolApproval::forProtocol($protocolId)->get()->keyBy('StepOrder');
            $now = now();
            $step = 0;

            $assigned = [];
            foreach ($reviewerIds as $userId) {
                $step++;
                $this->upsertApprovalStep($existing, $protocolId, $step, ProtocolApproval::ROLE_REVIEWER, (int) $userId, $now);
                $assigned[] = $step;
            }

            if ($approverId) {
                $step++;
                $this->upsertApprovalStep($existing, $protocolId, $step, ProtocolApproval::ROLE_APPROVER, $approverId, $now);
                $assigned[] = $step;
            }

            ProtocolApproval::where('ProtocolID', $protocolId)
                ->whereNotIn('StepOrder', $assigned ?: [0])
                ->delete();

            $hasDecided = ProtocolApproval::where('ProtocolID', $protocolId)
                ->where('Decision', '!=', ProtocolApproval::DECISION_PENDING)
                ->exists();

            if (! $hasDecided) {
                Protocol::where('ProtocolID', $protocolId)->update(['ProtocolStatusID' => 1]);
            } else {
                $this->syncProtocolStatus($protocolId);
            }
        });

        Toastr::success('Protocol Approval created successfully!', 'Success');

        return redirect()->back();
    }

    public function getApprovalDetails($id)
    {
        $steps = ProtocolApproval::forProtocol((int) $id)
            ->get(['StepOrder', 'Role', 'AssignedUserID', 'Decision']);

        return response()->json([
            'reviewers' => $steps->where('Role', ProtocolApproval::ROLE_REVIEWER)
                ->pluck('AssignedUserID')->values(),
            'approver' => $steps->firstWhere('Role', ProtocolApproval::ROLE_APPROVER)?->AssignedUserID,
        ]);
    }

    public function protocolApprovalDesign(Protocol $protocol, Request $request)
    {
        $request->validate([
            'step_id'  => 'required|integer',
            'decision' => 'required|in:Approved,Declined',
            'comment'  => 'nullable|string|max:2000',
        ]);

        try {
            DB::transaction(function () use ($protocol, $request) {
                $step = ProtocolApproval::where('ID', $request->step_id)
                    ->where('ProtocolID', $protocol->ProtocolID)
                    ->lockForUpdate()
                    ->first();

                if (! $step) {
                    abort(404, 'Approval step not found.');
                }

                if ($step->AssignedUserID !== Auth::id()) {
                    abort(403, 'You are not assigned to this approval step.');
                }

                if (! $step->isPending()) {
                    abort(409, 'This step has already been decided.');
                }

                $blocker = ProtocolApproval::where('ProtocolID', $protocol->ProtocolID)
                    ->where('StepOrder', '<', $step->StepOrder)
                    ->where('Decision', ProtocolApproval::DECISION_PENDING)
                    ->exists();

                if ($blocker) {
                    abort(409, 'A previous step is still pending. Please wait until prior reviewers complete.');
                }

                $step->update([
                    'Decision'  => $request->decision,
                    'Comment'   => $request->comment,
                    'DecidedAt' => now(),
                ]);

                $this->syncProtocolStatus($protocol->ProtocolID);
            });

            Toastr::success('Protocol Approval Update successfully!', 'Success');
            return redirect()->back();
        } catch (\Throwable $e) {
            Log::error('Protocol Approval Update Failed: ' . $e->getMessage());
            Toastr::error('Failed to update protocol approval. Please try again.', 'Error');
            return redirect()->back()->withErrors(['error' => 'An error occurred while updating protocol approval.']);
        }
    }

    private function upsertApprovalStep($existing, int $protocolId, int $step, string $role, int $userId, $now): void
    {
        $current = $existing->get($step);

        if ($current && $current->AssignedUserID === $userId && $current->Role === $role) {
            return;
        }

        if ($current) {
            $current->update([
                'Role'           => $role,
                'AssignedUserID' => $userId,
                'AssignedBy'     => Auth::id(),
                'AssignedAt'     => $now,
                'Decision'       => ProtocolApproval::DECISION_PENDING,
                'Comment'        => null,
                'DecidedAt'      => null,
            ]);
            return;
        }

        ProtocolApproval::create([
            'ProtocolID'     => $protocolId,
            'StepOrder'      => $step,
            'Role'           => $role,
            'AssignedUserID' => $userId,
            'AssignedBy'     => Auth::id(),
            'AssignedAt'     => $now,
            'Decision'       => ProtocolApproval::DECISION_PENDING,
        ]);
    }

    private function syncProtocolStatus(int $protocolId): void
    {
        $steps = ProtocolApproval::forProtocol($protocolId)->get();
        if ($steps->isEmpty()) {
            return;
        }

        $declined = $steps->firstWhere('Decision', ProtocolApproval::DECISION_DECLINED);
        if ($declined) {
            Protocol::where('ProtocolID', $protocolId)->update(['ProtocolStatusID' => 5]);
            return;
        }

        $approver = $steps->firstWhere('Role', ProtocolApproval::ROLE_APPROVER);
        if ($approver && $approver->isApproved()) {
            Protocol::where('ProtocolID', $protocolId)->update(['ProtocolStatusID' => 4]);
            return;
        }

        $reviewers = $steps->where('Role', ProtocolApproval::ROLE_REVIEWER);
        $reviewerCount = $reviewers->count();
        $reviewedCount = $reviewers->where('Decision', ProtocolApproval::DECISION_APPROVED)->count();

        if ($reviewerCount > 0 && $reviewedCount === $reviewerCount) {
            Protocol::where('ProtocolID', $protocolId)->update(['ProtocolStatusID' => 3]);
            return;
        }

        if ($reviewedCount > 0) {
            Protocol::where('ProtocolID', $protocolId)->update(['ProtocolStatusID' => 2]);
            return;
        }

        Protocol::where('ProtocolID', $protocolId)->update(['ProtocolStatusID' => 1]);
    }

    public function reasonStore(Protocol $protocol, Request $request)
    {
        $request->validate([
            'ProtocolID' => 'required',
            'Reason'     => 'required|string|max:255',
        ]);

        try {
            DB::table('ProtocolHistoryReason')->insert([
                'ProtocolID' => $request->ProtocolID,
                'Reason'     => $request->Reason,
                'CreatedBy'  => Auth::id(),
                'CreatedAt'  => now(),
            ]);

            Toastr::success('Reason updated successfully!', 'Success');
        } catch (\Throwable $e) {
            Log::error('Error in reasonStore: ' . $e->getMessage(), ['exception' => $e]);
            Toastr::error('An error occurred while updating the reason.', 'Error');
        }

        return redirect()->back();
    }
}
