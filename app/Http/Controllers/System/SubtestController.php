<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Subtest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SubtestController extends Controller
{
    public function index(Subtest $subtest, Request $request)
    {
        if ($request->ajax()) {
            $authUser = Auth::user();

            return DataTables::of($subtest->getSubTest())
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($authUser) {
                    $editLink = $authUser?->hasPermission('SubtestController@edit') ? route('subtest.edit', $row->SubtestID) : null;
                    $deleteLink = $authUser?->hasPermission('SubtestController@delete') ? route('subtest.delete', $row->SubtestID) : null;
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
