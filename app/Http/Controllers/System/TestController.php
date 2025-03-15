<?php

namespace App\Http\Controllers\System;

use App\Models\Test;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subtest;
use Yajra\DataTables\Facades\DataTables;

class TestController extends Controller
{
    public function index(Test $test, Request $request)
    {
        if ($request->ajax()) {
            $data = $test->getTest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('subtest', function ($test) {
                    $SubTestName = [];
                    foreach ($test->child as $key => $subtest) {
                        $SubTestName[$key] = $subtest->SubTestName;
                    }
                    return $SubTestName;
                })
                ->addColumn('action', function ($row) {
                    $editLink = route('test.edit', $row->TestID);
                    $deleteLink = route('test.delete', $row->TestID);
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
        Subtest::where('TestID', $test->TestID)->delete();

        $test->delete();

        return $this->success('test', 'Test deleted successfully!');
    }
}
