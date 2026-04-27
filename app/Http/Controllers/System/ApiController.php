<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAPIDetailRequest;
use App\Models\ApiDetail;
use App\Models\ProtocolAPIDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ApiController extends Controller
{
    public function index(ApiDetail $api, Request $request)
    {
        if ($request->ajax()) {
            $authUser = Auth::user();

            return DataTables::of($api->getAPIDetail()->with('batchs:ApiDetailID,BatchNo'))
                ->addIndexColumn()
                ->addColumn('batchs', fn ($api) => $api->batchs->pluck('BatchNo')->values()->all())
                ->addColumn('action', function ($row) use ($authUser) {
                    $editLink = $authUser?->hasPermission('ApiController@edit') ? route('apidetail.edit', $row->ApiDetailID) : null;
                    $deleteLink = $authUser?->hasPermission('ApiController@delete') ? route('apidetail.delete', $row->ApiDetailID) : null;
                    return getDynamicButtonLinkForEditModal($editLink, $deleteLink);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('system.apidetail.index');
    }

    public function store(ApiDetail $ApiDetail, CreateAPIDetailRequest $request)
    {
        $ApiDetail->createApiDetail($request);

        return $this->success('apidetail', 'Api Detail created successfully!');
    }

    public function edit(ApiDetail $apiDetail)
    {
        $apiDetail->load('batchs');
        $BatchNo = $apiDetail->batchs->pluck('BatchNo')->values()->all();

        return view('system.apidetail.modal.__edit', compact('apiDetail', 'BatchNo'))->render();
    }

    public function update(ApiDetail $apiDetail, Request $request)
    {
        $apiDetail->editApiDetail($apiDetail, $request);

        return $this->success('apidetail', 'Api Detail updated successfully!');
    }

    public function delete(ApiDetail $apiDetail)
    {
        $isUsedInProtocol = ProtocolAPIDetail::where('ApiDetailID', $apiDetail->ApiDetailID)->exists();

        if ($isUsedInProtocol) {
            return $this->error('apidetail', 'Cannot delete API Detail as it is associated with protocols.');
        }

        $apiDetail->delete();

        return $this->success('apidetail', 'API Detail deleted successfully!');
    }
}
