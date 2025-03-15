<?php

namespace App\Http\Controllers\System;

use App\Models\ApiDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAPIDetailRequest;
use Yajra\DataTables\Facades\DataTables;

class ApiController extends Controller
{
    public function index(ApiDetail $api, Request $request)
    {
        if ($request->ajax()) {
            $data = $api->getApiDetail();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('batchs', function ($api) {
                    $BatchNo = [];
                    foreach ($api->batchs as $key => $batch) {
                        $BatchNo[$key] = $batch->BatchNo;
                    }
                    return $BatchNo;
                })
                ->addColumn('action', function ($row) {
                    $editLink = route('apidetail.edit', $row->ApiDetailID);
                    $deleteLink = route('apidetail.delete', $row->ApiDetailID);
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
        $BatchNo = [];

        foreach ($apiDetail->batchs->pluck('BatchNo') as $key => $value) {
            $BatchNo[$key] = $value;
        }

        $apiDetail = $apiDetail->load('batchs');

        return view('system.apidetail.modal.__edit', compact('apiDetail', 'BatchNo'))->render();
    }

    public function update(ApiDetail $apiDetail, Request $request)
    {
        $apiDetail->editApiDetail($apiDetail, $request);

        return $this->success('apidetail', 'Api Detail updated successfully!');
    }

    public function delete(ApiDetail $apiDetail)
    {
        $apiDetail->delete();

        return $this->success('apidetail', 'Api Detail deleted successfully!');
    }
}
