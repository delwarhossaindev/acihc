<?php

namespace App\Http\Controllers\System;

use App\Models\Pack;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PackCreateRequest;
use Yajra\DataTables\Facades\DataTables;

class PackController extends Controller
{
    public function index(Pack $pack, Request $request)
    {
        if ($request->ajax()) {
            $data = $pack->getPack();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editLink = route('pack.edit', $row->PackID);
                    $deleteLink = route('pack.delete', $row->PackID);
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
