<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Subtest;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TestController extends Controller
{
    public function index(Test $test, Request $request)
    {
        if ($request->ajax()) {
            $authUser = Auth::user();

            return DataTables::of(Test::with('child:SubtestID,TestID,SubTestName'))
                ->addIndexColumn()
                ->addColumn('subtest', fn ($test) => $test->child->pluck('SubTestName')->values()->all())
                ->addColumn('action', function ($row) use ($authUser) {
                    $editLink = $authUser?->hasPermission('TestController@edit') ? route('test.edit', $row->TestID) : null;
                    $deleteLink = $authUser?->hasPermission('TestController@delete') ? route('test.delete', $row->TestID) : null;
                    return getDynamicButtonLinkForEditModal($editLink, $deleteLink);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('system.test.index');
    }

    public function store(Test $test, Request $request)
    {
        $test->createTest($request);

        return $this->success('test', 'Test created successfully!');
    }

    public function edit(Test $test)
    {
        return view('system.test.modal.__edit', compact('test'))->render();
    }

    public function update(Test $test, Request $request)
    {
        $test->updateTest($test, $request);

        return $this->success('test', 'Test updated successfully!');
    }

    public function delete(Test $test)
    {
        DB::transaction(function () use ($test) {
            Subtest::where('TestID', $test->TestID)->delete();
            $test->delete();
        });

        return $this->success('test', 'Test deleted successfully!');
    }
}
