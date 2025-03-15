<?php

namespace App\Http\Controllers\System;

use App\Models\Packaging;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PackagingController extends Controller
{
    public function index(Packaging $packaging, Request $request)
    {
        if ($request->ajax()) {
            $data = $packaging->getPackaging();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editLink = route('packaging.edit', $row->PackagingID);
                    $deleteLink = route('packaging.delete', $row->PackagingID);
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
