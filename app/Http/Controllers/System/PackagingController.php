<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Packaging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PackagingController extends Controller
{
    public function index(Packaging $packaging, Request $request)
    {
        if ($request->ajax()) {
            $authUser = Auth::user();

            return DataTables::of($packaging->getPackaging())
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($authUser) {
                    $editLink = $authUser?->hasPermission('PackagingController@edit') ? route('packaging.edit', $row->PackagingID) : null;
                    $deleteLink = $authUser?->hasPermission('PackagingController@delete') ? route('packaging.delete', $row->PackagingID) : null;
                    return getDynamicButtonLinkForEditModal($editLink, $deleteLink);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('system.packaging.index');
    }

    public function store(Packaging $packaging, Request $request)
    {
        $packaging->createPackaging($request);

        return $this->success('packaging', 'Packaging created successfully!');
    }

    public function edit(Packaging $packaging)
    {
        return view('system.packaging.modal.__edit', compact('packaging'))->render();
    }

    public function update(Packaging $packaging, Request $request)
    {
        $packaging->updatePackaging($packaging, $request);

        return $this->success('packaging', 'Packaging updated successfully!');
    }

    public function delete(Packaging $packaging)
    {
        $packaging->delete();

        return $this->success('packaging', 'Packaging deleted successfully!');
    }
}
