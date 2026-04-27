<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
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
        $studyType = StudyType::with('details:StudyTypeDetailID,StudyTypeID,StudyTypeMonth')->find($request->StudyTypeID);

        $studyMonth = $studyType
            ? $studyType->details->pluck('StudyTypeMonth')->values()->all()
            : [];

        $tests = Test::all();
        $subTests = Subtest::all();

        return response()->json([
            'loop'     => count($studyMonth),
            'month'    => $studyMonth,
            'loopTest' => $tests->count() + $subTests->count(),
            'Test'     => $tests,
            'SubTest'  => $subTests,
        ]);
    }

    public function getTestType(Request $request)
    {
        $testId = (string) $request->TestID;

        if (Str::startsWith($testId, 'sub')) {
            $factor = Str::replaceFirst('sub', '', $testId);
            $type = Subtest::find($factor)?->TestType;
        } else {
            $factor = Str::replaceFirst('t', '', $testId);
            $type = Test::find($factor)?->TestType;
        }

        return response()->json(['type' => $type]);
    }

    public function getProductStrength(Request $request)
    {
        $protocol = Protocol::with('product.skus:SkuID,ProductID,ProductStrength')->find($request->ProtocolID);

        $strengths = $protocol?->product?->skus?->pluck('ProductStrength') ?? collect();

        return response()->json([
            'loop'      => $strengths->count(),
            'strengths' => $strengths->values(),
        ]);
    }

    public function getProduct(Request $request)
    {
        $protocol = Protocol::with([
            'product.skus',
            'product.packs',
            'statbilityStudy.study.details',
        ])->where('ProtocolID', $request->ProtocolID)->first();

        if (! $protocol) {
            return response()->json(['error' => 'Protocol not found'], 404);
        }

        $months = $protocol->statbilityStudy
            ->flatMap(fn ($stability) => $stability->study?->details?->pluck('StudyTypeMonth') ?? collect())
            ->unique()
            ->values();

        return response()->json([
            'product' => $protocol->product,
            'skus'    => $protocol->product?->skus,
            'packs'   => $protocol->product?->packs,
            'months'  => $months,
        ]);
    }
}
