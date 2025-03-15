<?php

namespace App\Http\Controllers\System;

use App\Models\Subtest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mockery\Matcher\Subset;
use Yajra\DataTables\Facades\DataTables;

class SubtestController extends Controller
{
    public function index(Subtest $subtest, Request $request)
    {
        if ($request->ajax()) {
            $data = $subtest->getSubTest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editLink = route('subtest.edit', $row->SubtestID);
                    $deleteLink = route('subtest.delete', $row->SubtestID);
                    return getDynamicButtonLinkForEditModal($editLink, $deleteLink);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('system.subtest.index');
    }

    public function edit(Subtest $subtest)
    {
        return view('system.subtest.modal.__edit', compact('subtest'))->render();
    }

    public function update(Request $request, Subtest $subtest)
    {
        $subtest->updateSubTest($subtest, $request);

        return $this->success('subtest', 'Sub Test updated successfully!');
    }

    public function delete(Subtest $subtest)
    {
        $subtest->delete();

        return $this->success('subtest', 'Sub Test deleted successfully!');
    }
}
