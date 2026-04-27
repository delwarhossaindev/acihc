<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Sample;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SampleController extends Controller
{
    public function index(Sample $sample, Request $request)
    {
        if ($request->ajax()) {
            $authUser = Auth::user();

            $query = Sample::with([
                'product:ProductID,ProductName',
                'manufacturer:ManufacturerID,ManufacturerName',
                'protocol:ProtocolID,Title',
            ]);

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($authUser) {
                    $edit = $authUser?->hasPermission('SampleController@edit') ? route('sample.edit', $row->SampleID) : null;
                    $show = $authUser?->hasPermission('SampleController@show') ? route('sample.show', $row->SampleID) : null;
                    $delete = $authUser?->hasPermission('SampleController@delete') ? route('sample.delete', $row->SampleID) : null;
                    return sampleButton($edit, $show, $delete);
                })
                ->editColumn('ReceivingDate', fn ($row) => $row->ReceivingDate ? Carbon::parse($row->ReceivingDate)->toFormattedDateString() : null)
                ->editColumn('PackagingDate', fn ($row) => $row->PackagingDate ? Carbon::parse($row->PackagingDate)->toFormattedDateString() : null)
                ->addColumn('ProductName', fn ($row) => $row->product->ProductName ?? '')
                ->addColumn('ManufacturerName', fn ($row) => $row->manufacturer->ManufacturerName ?? '')
                ->addColumn('protocol', fn ($row) => $row->protocol->Title ?? '')
                ->addColumn('SampleNo', fn ($row) => 'STB/SAMPLE/' . sprintf('%03d', $row->SampleID))
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('system.sample.index');
    }

    public function store(Sample $sample, Request $request)
    {
        $sample->createSample($request);

        return $this->success('sample.index', 'Sample created successfully!');
    }

    public function edit(Sample $sample)
    {
        return view('system.sample.modal.__edit', compact('sample'))->render();
    }

    public function update(Sample $sample, Request $request)
    {
        $sample->updateSample($sample, $request);

        return $this->success('sample.index', 'Sample updated successfully!');
    }

    public function delete(Sample $sample)
    {
        $sample->delete();

        return $this->success('sample.index', 'Sample deleted successfully!');
    }

    public function show(Sample $sample)
    {
        return view('system.sample.show', compact('sample'));
    }
}
