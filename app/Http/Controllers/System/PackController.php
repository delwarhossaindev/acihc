<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackCreateRequest;
use App\Models\Pack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PackController extends Controller
{
    public function index(Pack $pack, Request $request)
    {
        if ($request->ajax()) {
            $authUser = Auth::user();

            return DataTables::of($pack->getPack())
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($authUser) {
                    $editLink = $authUser?->hasPermission('PackController@edit') ? route('pack.edit', $row->PackID) : null;
                    $deleteLink = $authUser?->hasPermission('PackController@delete') ? route('pack.delete', $row->PackID) : null;
                    return getDynamicButtonLinkForEditModal($editLink, $deleteLink);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('system.pack.index');
    }

    public function store(Pack $pack, PackCreateRequest $request)
    {
        $pack->createPack($request);

        return $this->success('pack', 'Pack created successfully!');
    }

    public function edit(Pack $pack)
    {
        return view('system.pack.modal.__edit', compact('pack'))->render();
    }

    public function update(Pack $pack, Request $request)
    {
        $pack->updatePack($pack, $request);

        return $this->success('pack', 'Pack updated successfully!');
    }

    public function delete(Pack $pack)
    {
        $pack->delete();

        return $this->success('pack', 'Pack deleted successfully!');
    }
}
