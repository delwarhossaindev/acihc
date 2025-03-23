<?php
namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProtocolRequest;
use App\Models\Placebo;
use App\Models\Protocol;
use App\Models\ProtocolApprovalTree;
use App\Models\ProtocolApprover;
use App\Models\ProtocolBatch;
use App\Models\ProtocolPlaceboDetail;
use App\Models\ProtocolReviewer;
use App\Models\ProtocolSkuUnitPack;
use App\Models\ProtocolStabilityChamberDesign;
use App\Models\ProtocolSubTest;
use App\Models\ProtocolTest;
use App\Models\ProtocolTestPackBottle;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProtocolController extends Controller
{
    public function index(Protocol $protocol, Request $request)
    {

        if ($request->ajax()) {
            $data = $protocol->getProtocol()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($protocol) {
                    return $protocol->user->name ?? 'N/A';
                })
                ->addColumn('updatedby', function ($protocol) {
                    return $protocol->updatedby->name ?? 'N/A';
                })

                ->addColumn('protocolNo', function ($protocol) {
                    $versionCount = DB::table('ProtocolVersion')
                        ->where('protocol_id', $protocol->ProtocolID)
                        ->lockForUpdate()
                        ->max('version_no');
                    $versionCount =     number_format((float)$versionCount, 2, '.', '') ?? number_format((float)1.00, 2, '.', '') ;

                    return 'STB/PROT/' . sprintf('%04d', $protocol->ProtocolID) . '; Version: ' . $versionCount;
                })
                ->addColumn('Status', function ($protocol) {
                    $ProtocolStatus = DB::table('ProtocolStatus')
                        ->where('ProtocolStatusID', $protocol->ProtocolStatusID)->first();

                    return $ProtocolStatus ? $ProtocolStatus->ProtocolStatus : '';
                })

                ->addColumn('product', function ($protocol) {
                    $productName = $protocol->product->ProductName ?? 'N/A';

                    if ($protocol->product->skus->isNotEmpty()) {
                        $productStrengths = $protocol->product->skus->pluck('ProductStrength')->toArray();
                        $strengthString   = implode(',', $productStrengths);
                        return $productName . '(' . $strengthString . ')';
                    } else {
                        return $productName;
                    }
                })
            // ->addColumn('product', function ($protocol) {
            //     return $protocol->product->ProductName . '(' . implode($protocol->product->skus->pluck('ProductStrength')->toArray(),',') . ')';
            // })
                ->addColumn('action', function ($row) {
                    $editLink   = route('protocol.edit', $row->ProtocolID);
                    $showLink   = route('protocol.show', $row->ProtocolID);
                    $ProtocolID = $row->ProtocolID;
                    return ProtocolButton($editLink, $showLink, $ProtocolID);
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
        return view('system.protocol.create', compact('protocol'));
    }

    public function show(Protocol $protocol)
    {
        $protocol = $protocol->load([
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

        return view('system.protocol.show', compact('protocol', 'stabilityDesignTitle'));
    }

    public function store(Protocol $protocol, CreateProtocolRequest $request)
    {

        $protocol = $protocol->storeProtocol($request);

        DB::table('ProtocolVersion')->insert([
            'protocol_id' => $protocol->ProtocolID,
            'version_no'  => 1,
            'created_at'  => now(),
            'created_by'  => auth()->user()->id,
        ]);

        // ProtocolApprovalTree::create([
        //     'protocol_id' => $protocol->ProtocolID,
        //     'version_no' => 1,
        //     'created_at' => now(),
        //     'created_by' => auth()->user()->id
        // ]);

        Toastr::success('Protocol created successfully!!', 'Success');

        return redirect()->route('protocol.edit', $protocol->ProtocolID);
    }

    public function updateProtocol(Protocol $protocol, CreateProtocolRequest $request)
    {

        DB::transaction(function () use ($protocol) {
            // Fetch the current highest version for the given protocol
            $currentVersion = DB::table('ProtocolVersion')
                ->where('protocol_id', $protocol->ProtocolID)
                ->lockForUpdate()
                ->max('version_no');



            // If no version exists, set it to 1.00; otherwise, increment by 0.01

            if ($protocol->ProtocolStatusID == 4) {
                $newVersion = $currentVersion ? number_format($currentVersion + 1.00, 2, '.', '') : '1.00';
            } else {
                $newVersion = $currentVersion ? number_format($currentVersion + 0.01, 2, '.', '') : '1.00';
            }

            // Insert the new version
            DB::table('ProtocolVersion')->insert([
                'protocol_id' => $protocol->ProtocolID,
                'version_no'  => $newVersion,
                'created_at'  => now(),
                'created_by'  => auth()->user()->id,
            ]);
        });

        $protocol = $protocol->updateProtocol($protocol, $request);

        Toastr::success('Protocol updated successfully!!', 'Success');

        return redirect()->back();
    }

    /**
     * Protocol API Details
     *
     */
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

    /**
     * Protocol Product Details
     */
    public function storeProductDetails(Protocol $protocol, Request $request)
    {
        $protocol->storeProtocolProductDetails($protocol, $request);

        Toastr::success('Product information added successfully!', 'Success');

        return redirect()->back();
    }

    /**
     * Packaging Materials
     */
    public function storeSkuContainerStore(Protocol $protocol, Request $request)
    {
        $protocol->storeProtocolSkuContainerType($protocol, $request);

        Toastr::success('Packaging profile information added successfully!', 'Success');

        return redirect()->back();
    }

    /**
     * Packaging Profile
     */
    public function storeProtocolPackagingProfile(Protocol $protocol, Request $request)
    {
      
        $protocol->storeProtocolPackagingProfile($protocol, $request);

        Toastr::success('Packaging profile information added successfully!', 'Success');

        return redirect()->back();
    }

    /**
     * Stability Study
     */

    public function storeProtocolStabilityStudy(Protocol $protocol, Request $request)
    {

        $protocol->storeProtocolStabilityStudy($protocol, $request);

        Toastr::success('Stability study information added successfully!', 'Success');

        return redirect()->back();
    }

    public function storeProtocolTestDetail(Protocol $protocol, Request $request)
    {
        // $protocol->storeProtocolTestStudy($protocol, $request);

       // dd($request->all());

        //return $request;

        $data = $request->all();
       // dd($data);
        unset($data['_token']);
        unset($data['test']);

        if ($protocol->tests->count() > 0) {
            ProtocolTestPackBottle::where('ProtocolID',$protocol->ProtocolID)->delete();
            ProtocolTest::where('ProtocolID', $protocol->ProtocolID)->delete();
            ProtocolSubTest::where('ProtocolID', $protocol->ProtocolID)->delete();

            //return $request->test;
            foreach ($data as $key => $value) {
                //return $value['TestID'][0];
                $contains = Str::contains($value['TestID'][0], 't');
                if ($contains) {
                    $test                     = Str::replace('t', '', $value['TestID'][0]);
                    $ProtocolTest             = new ProtocolTest();
                    $ProtocolTest->ProtocolID = $protocol->ProtocolID;
                    $ProtocolTest->TestID     = $test;
                    $ProtocolTest->Value      = json_encode($value['Value']);
                    $ProtocolTest->save();
                } else {
                    $subtest                     = Str::replace('sub', '', $value['TestID'][0]);
                    $ProtocolSubTest             = new ProtocolSubTest();
                    $ProtocolSubTest->ProtocolID = $protocol->ProtocolID;
                    $ProtocolSubTest->SubTestID  = $subtest;
                    $ProtocolSubTest->Value      = json_encode($value['Value']);
                    $ProtocolSubTest->save();
                }
            }



            foreach ($request->test as $value) {

                $ProtocolTestPackBottle                 = new ProtocolTestPackBottle;
                $ProtocolTestPackBottle->ProtocolID     = $protocol->ProtocolID;
                $ProtocolTestPackBottle->PackID         = json_encode($value);
                $ProtocolTestPackBottle->NumberOfBottle = json_encode(array_filter($request->test['UnitPerTest']));
                $ProtocolTestPackBottle->save();
                break;
            }

            Toastr::success('Test information updated successfully!', 'Success');

            return redirect()->back();
        }

        //return $request->test;
        foreach ($data as $key => $value) {
            //return $value['TestID'][0];
            $contains = Str::contains($value['TestID'][0], 't');
            if ($contains) {
                $test                     = Str::replace('t', '', $value['TestID'][0]);
                $ProtocolTest             = new ProtocolTest();
                $ProtocolTest->ProtocolID = $protocol->ProtocolID;
                $ProtocolTest->TestID     = $test;
                $ProtocolTest->Value      = json_encode($value['Value']);
                $ProtocolTest->save();
            } else {
                $subtest                     = Str::replace('sub', '', $value['TestID'][0]);
                $ProtocolSubTest             = new ProtocolSubTest();
                $ProtocolSubTest->ProtocolID = $protocol->ProtocolID;
                $ProtocolSubTest->SubTestID  = $subtest;
                $ProtocolSubTest->Value      = json_encode($value['Value']);
                $ProtocolSubTest->save();
            }
        }

        foreach ($request->test as $value) {

            $ProtocolTestPackBottle                 = new ProtocolTestPackBottle;
            $ProtocolTestPackBottle->ProtocolID     = $protocol->ProtocolID;
            $ProtocolTestPackBottle->PackID         = json_encode($value);
            $ProtocolTestPackBottle->NumberOfBottle = json_encode($request->test['UnitPerTest']);
            $ProtocolTestPackBottle->save();
            break;
        }




        Toastr::success('Test information added successfully!', 'Success');

        return redirect()->back();
    }

    public function protocolChamberDesignOld(Protocol $protocol, Request $request)
    {


        $data  = $request->all();
        $title = $data['title'];
        unset($data['_token']);
        unset($data['title']);

        if ($protocol->protocolSkuUnitPack()->count() > 0) {
            foreach ($protocol->protocolSkuUnitPack as $key => $value) {
                ProtocolStabilityChamberDesign::where('ProtocolSkuUnitPackID', $value->ProtocolSkuUnitPackID)->delete();
            }
            ProtocolSkuUnitPack::where('ProtocolID', $protocol->ProtocolID)->delete();
            DB::table('StabilityDesignTitle')->where('ProtocolID', $protocol->ProtocolID)->delete();
        }

        foreach ($data as $index => $value) {

            $skuidCount          = count($value['SkuID']);
            $StudyTypeMonthCount = count($value['StudyTypeMonth']);
            $chuckSize           = $StudyTypeMonthCount / $skuidCount;
            $finalMonth          = array_chunk($value['StudyTypeMonth'], $chuckSize);

            foreach ($value['SkuID'] as $key => $value) {
                $protocolSkuUnitPack = $protocol->protocolSkuUnitPack()->create([
                    'SkuID'      => $value,
                    'PackID'     => $data[$index]['PackID'][$key],
                    'Month'      => json_encode($finalMonth[$key]),
                    'Additional' => $data[$index]['Additional'][$key],
                ]);
            }
        }

        DB::table('StabilityDesignTitle')->insert([
            'ProtocolID' => $protocol->ProtocolID,
            'Title'      => serialize($title),
        ]);

        Toastr::success('Stability design added successfully!', 'Success');

        return redirect()->back();
    }

    public function protocolChamberDesign(Protocol $protocol, Request $request)
    {
        $data              = $request->all();
        $title             = $data['title'];
        $PlaceboMonth      = $data['PlaceboMonth'];
        $PlaceboAdditional = $data['PlaceboAdditional'];
        unset($data['_token'], $data['title'], $data['PlaceboMonth'], $data['PlaceboAdditional']);



        // Begin transaction
        DB::beginTransaction();

        try {
            // Delete existing records if they exist
            if ($protocol->protocolSkuUnitPack()->count() > 0) {
                foreach ($protocol->protocolSkuUnitPack as $value) {
                    ProtocolStabilityChamberDesign::where('ProtocolSkuUnitPackID', $value->ProtocolSkuUnitPackID)->delete();
                }
                ProtocolSkuUnitPack::where('ProtocolID', $protocol->ProtocolID)->delete();
                DB::table('StabilityDesignTitle')->where('ProtocolID', $protocol->ProtocolID)->delete();
                DB::table('PlaceboSkuUnitPack')->where('ProtocolID', $protocol->ProtocolID)->delete();
            }

            // Insert new records
            foreach ($data as $index => $value) {

                $skuidCount          = isset($value['SkuID'])? count($value['SkuID']): count($value['PlaceboSkuID']);
                $StudyTypeMonthCount = count($value['StudyTypeMonth']);
                $chunkSize           = $StudyTypeMonthCount / $skuidCount;
                $finalMonth          = array_chunk($value['StudyTypeMonth'], $chunkSize);

              if(isset($value['SkuID'])){
                foreach ($value['SkuID'] as $key => $skuID) {
                    $protocol->protocolSkuUnitPack()->create([
                        'SkuID'      => $skuID,
                        'PackID'     => $data[$index]['PackID'][$key],
                        'Month'      => json_encode($finalMonth[$key]),
                        'Additional' => $data[$index]['Additional'][$key],
                    ]);
                }
              }

              if(isset($value['PlaceboSkuID'])){
                foreach ($value['PlaceboSkuID'] as $key => $skuID) {
                    $protocol->protocolSkuUnitPack()->create([
                        'SkuID'      => $skuID,
                        'PackID'     => $data[$index]['PackID'][$key],
                        'Month'      => json_encode($finalMonth[$key]),
                        'Additional' => $data[$index]['Additional'][$key],
                    ]);
                }
              }

            }

            // Insert title
            DB::table('StabilityDesignTitle')->insert([
                'ProtocolID' => $protocol->ProtocolID,
                'Title'      => serialize($title),
            ]);

            // Insert title
            DB::table('PlaceboSkuUnitPack')->insert([
                'ProtocolID' => $protocol->ProtocolID,
                'Month'      => json_encode($PlaceboMonth),
                'Additional' => $PlaceboAdditional,
            ]);

            // Commit the transaction
            DB::commit();

            Toastr::success('Stability design added successfully!', 'Success');
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();

            Toastr::error('Failed to add stability design.', 'Error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->back();
    }

    public function protocolPlaceboDesign(Protocol $protocol, Request $request)
    {
        $data = $request->all();
        unset($data['_token']);

        if ($protocol->protocolPlacebo()->count() > 0) {
            foreach ($protocol->protocolPlacebo as $key => $value) {
                ProtocolPlaceboDetail::where('PlaceboID', $value->PlaceboID)->delete();
            }
            Placebo::where('ProtocolID', $protocol->ProtocolID)->delete();
        }

        foreach ($data as $key => $value) {

            if (isset($data[$key]['SkuID'][0])) {
                $protocolPlacebo = $protocol->protocolPlacebo()->create([
                    'SkuID'  => $data[$key]['SkuID'][0],
                    'PackID' => $data[$key]['PackID'][0],
                ]);
            }

            if (isset($data[$key]['SkuID'][0])) {
                $unit = [];
                $unit = explode(",", $data[$key]['Unit'][0]);
                //dd($unit[1]);
                if (isset($value['StudTypeID'])) {
                    foreach ($value['StudTypeID'] as $index => $StudyTypeID) {
                        //dd($StudyTypeID);
                        $protocolPlacebo->placeboDetails()->create([
                            'StudyTypeID'     => $StudyTypeID,
                            'Month'           => $data[$key]['Month'][0],
                            'Count'           => $unit[$index],
                            'AditionalSample' => $data[$key]['AditionalSample'][0],
                        ]);
                        //dd($month);
                    }
                }
            }
        }

        Toastr::success('Protocol Placebo created successfully!', 'Success');

        return redirect()->back();
    }

    public function protocolBatchDesign(Protocol $protocol, Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        //return $data;
        if ($protocol->protocolBatch()->count() > 0) {
            ProtocolBatch::where('ProtocolID', $protocol->ProtocolID)->delete();
        }
        //$batch = [];
        foreach ($data['BatchID'] as $key => $value) {
            //$batch[$key] = $value;
            //dd($value[1]);
            if (isset($data['BatchID'][$key]) && $data['SkuID'][$key]) {
                $protocol->protocolBatch()->create([
                    'BatchID'                 => $value,
                    'SkuID'                   => $data['SkuID'][$key],
                    'BatchNo'                 => isset($data['BatchNo'][$key]) ? $data['BatchNo'][$key] : '',
                    'BatchSize'               => isset($data['BatchSize'][$key]) ? $data['BatchSize'][$key] : '',
                    'MfgDate'                 => isset($data['MfgDate'][$key]) ? $data['MfgDate'][$key] : '',
                    'StabilityInitiationDate' => isset($data['StabilityInitiationDate'][$key]) ? $data['StabilityInitiationDate'][$key] : '',
                ]);
            }
        }
        //return $batch;
        Toastr::success('Protocol batch created successfully!', 'Success');

        return redirect()->back();
    }

    public function approvalProtocalStore(Request $request)
    {
        // Validate the request
        $request->validate([
            'protocol_id' => 'required|integer',
            'ReviewBy'    => 'array|nullable',
            'ReviewBy.*'  => 'integer|exists:users,id',
            'ApprovalBy'  => 'nullable|integer|exists:users,id',
        ]);

        // Process ReviewBy if provided
        if (! empty($request->ReviewBy)) {

            ProtocolApprovalTree::where('ProtocolID', $request->protocol_id)
                ->where('ProtocolApprovalTypeID', 1)
                ->delete();

            ProtocolReviewer::where('ProtocolID', $request->protocol_id)
                ->delete();

            foreach ($request->ReviewBy as $userId) {

                ProtocolApprovalTree::create([
                    'ProtocolID'             => $request->protocol_id,
                    'ProtocolApprovalTypeID' => 1,
                    'UserID'                 => $userId,
                    'CreateDate'             => now(),
                ]);

                // ProtocolReviewer::create([
                //     'ProtocolID' => $request->protocol_id,
                //     'UserID' => $userId,
                //     'CreateDate' => now(),
                // ]);
            }
        }

        // Process ApprovalBy if provided
        if ($request->ApprovalBy) {

            ProtocolApprovalTree::where('ProtocolID', $request->protocol_id)
                ->where('ProtocolApprovalTypeID', 2)
                ->delete();

            ProtocolApprover::where('ProtocolID', $request->protocol_id)
                ->delete();

            ProtocolApprovalTree::create([
                'ProtocolID'             => $request->protocol_id,
                'ProtocolApprovalTypeID' => 2,
                'UserID'                 => $request->ApprovalBy,
                'CreateDate'             => now(),
            ]);

            Protocol::where('ProtocolID', $request->protocol_id)
                ->update([
                    'ProtocolStatusID' => 1,
                ]);

            // ProtocolApprover::create(
            //     [
            //         'ProtocolID' => $request->protocol_id,
            //         'UserID' => $request->ApprovalBy, // Corrected this to use ApprovalBy
            //         'CreateDate' => now(),
            //     ]
            // );
        }

        // Flash success message
        Toastr::success('Protocol Approval created successfully!', 'Success');

        // Redirect back
        return redirect()->back();
    }

    public function getApprovalDetails($id)
    {

        $reviewByOne = ProtocolApprovalTree::where('ProtocolID', $id)
            ->where('ProtocolApprovalTypeID', 1)
            ->first();

        $reviewByTwo = ProtocolApprovalTree::where('ProtocolID', $id)
            ->where('ProtocolApprovalTypeID', 1)
            ->latest('CreateDate')
            ->first();

        $approvalBy = ProtocolApprovalTree::where('ProtocolID', $id)
            ->where('ProtocolApprovalTypeID', 2)
            ->first();

        return response()->json([
            'reviewByOne' => $reviewByOne->UserID ?? null,
            'reviewByTwo' => $reviewByTwo->UserID ?? null,
            'approvalBy'  => $approvalBy->UserID ?? null,
        ]);
    }

    public function protocolApprovalDesign(Protocol $protocol, Request $request)
    {
        try {
            DB::beginTransaction();

            $reviewByOne = $request->reviewByOne ? json_decode($request->reviewByOne, true) : null;
            $reviewByTwo = $request->reviewByTwo ? json_decode($request->reviewByTwo, true) : null;
            $approvalBy  = $request->approvalBy ? json_decode($request->approvalBy, true) : null;

            if ($reviewByOne) {
                ProtocolReviewer::create([
                    'ProtocolID' => $reviewByOne['ProtocolID'],
                    'UserID'     => $reviewByOne['UserID'],
                    'Comment'    => $request->commentOne,
                    'CreateDate' => date('Y-m-d H:i:s'),
                ]);

                Protocol::where('ProtocolID', $protocol->ProtocolID)
                    ->update([
                        'ProtocolStatusID' => 2,
                    ]);
            }

            if ($reviewByTwo) {
                ProtocolReviewer::create([
                    'ProtocolID' => $protocol->ProtocolID,
                    'UserID'     => $reviewByTwo['UserID'],
                    'Comment'    => $request->commentTwo,
                    'CreateDate' => date('Y-m-d H:i:s'),
                ]);

                Protocol::where('ProtocolID', $protocol->ProtocolID)
                    ->update([
                        'ProtocolStatusID' => 3,
                    ]);
            }

            if ($approvalBy) {

                ProtocolApprover::create([
                    'ProtocolID' => $protocol->ProtocolID,
                    'UserID'     => $approvalBy['UserID'],
                    'Comment'    => $request->approvalComment,
                    'CreateDate' => date('Y-m-d H:i:s'),
                ]);

                Protocol::where('ProtocolID', $protocol->ProtocolID)
                    ->update([
                        'ProtocolStatusID' => $request->Approval === 'Approved' ? 4 : 5,
                    ]);
            }

            DB::commit();

            Toastr::success('Protocol Approval Update successfully!', 'Success');
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Protocol Approval Update Failed: ' . $e->getMessage());

            Toastr::error('Failed to update protocol approval. Please try again.', 'Error');
            return redirect()->back()->withErrors(['error' => 'An error occurred while updating protocol approval.']);
        }
    }

    public function reasonStore(Protocol $protocol, Request $request)
    {
        try {
            $validated = $request->validate([
                'ProtocolID' => 'required',
                'Reason'     => 'required|string|max:255',
            ]);

            DB::beginTransaction();

            DB::table('ProtocolHistoryReason')->insert([
                'ProtocolID' => $request->ProtocolID,
                'Reason'     => $request->Reason,
                'CreatedBy'  => auth()->user()->id,
                'CreatedAt'  => now(),
            ]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Reason updated successfully!',
                ]);
            }


        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in reasonStore: ' . $e->getMessage(), ['exception' => $e]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while updating the reason.',
                ], 500);
            }


        }

        //return redirect()->back();
    }

}
