<?php
namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Protocol;
use App\Models\StudyType;
use App\Models\Subtest;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AjaxController extends Controller
{
    public function getCondition(Request $request)
    {

        $Test    = Test::all();
        $SubTest = SubTest::all();

        

        $StudyType = StudyType::find($request->StudyTypeID);

        $studyMonth = [];

        foreach ($StudyType->details as $key => $value) {
            $studyMonth[$key] = $value->StudyTypeMonth;
        }

        return response()->json([
            'loop'     => count($studyMonth),
            'month'    => $studyMonth,
            'loopTest' => count($Test) + count($SubTest),
            'Test'     => $Test,
            'SubTest'  => $SubTest,
        ]);
    }

    public function getTestType(Request $request)
    {
        $contains = Str::contains($request->TestID, 't');

        if ($contains) {
            $factor   = Str::replace('t', '', $request->TestID);
            $TestType = Test::find($factor);
            return response()->json([
                'type' => $TestType->TestType,
            ]);
        } else {
            $factor   = Str::replace('sub', '', $request->TestID);
            $TestType = Subtest::find($factor);
            return response()->json([
                'type' => $TestType->TestType,
            ]);
        }

    }

    public function getProductStrength(Request $request)
    {
        $protocol = Protocol::find($request->ProtocolID);

        return response()->json([
            'loop'      => count($protocol->product->skus->pluck('ProductStrength')),
            'strengths' => $protocol->product->skus->pluck('ProductStrength'),
        ]);
    }

    public function getProduct(Request $request)
    {
        $protocol = Protocol::where('ProtocolID', $request->ProtocolID)->first();
        $months   = [];
        foreach ($protocol->statbilityStudy as $statbility) {
            $arrayMonth = $statbility->study->details->pluck('StudyTypeMonth');
            array_push($months, $arrayMonth);
        }
        $months = collect($months)->flatten()->unique();

        return response()->json([
            'product' => $protocol->product,
            'skus'    => $protocol->product->skus,
            'packs'   => $protocol->product->packs,
            'months'  => $months,
        ]);
    }
}
