<?php

namespace App\Http\Controllers\System;

use Carbon\Carbon;
use App\Models\Sample;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class SampleController extends Controller
{
    public function index(Sample $sample, Request $request)
    {
        $data = $sample->getSample();

        if ($request->has('from_date') && $request->has('to_date') && $request->from_date && $request->to_date) {
            $fromDate = Carbon::parse($request->from_date)->format('Y-m-d');
            $toDate = Carbon::parse($request->to_date)->format('Y-m-d');
            $data = $data->whereBetween('ReceivingDate', [$fromDate, $toDate]);
        }


        if ($request->ajax()) {
           
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $edit = route('sample.edit', $row->SampleID);
                    $show = route('sample.show', $row->SampleID);
                    $delete = route('sample.delete', $row->SampleID);
                    return sampleButton($edit, $show, $delete);
                })
                ->editColumn('ReceivingDate', function ($row) {
                    return $row->ReceivingDate ? Carbon::parse($row->ReceivingDate)->toFormattedDateString() : null;
                })
                ->editColumn('PackagingDate', function ($row) {
                    return $row->PackagingDate ? Carbon::parse($row->PackagingDate)->toFormattedDateString() : null;
                })
                ->addColumn('ProductName', function ($row) {
                    return $row->product->ProductName ?? '';
                })
                ->addColumn('ManufacturerName', function ($row) {
                    return $row->manufacturer->ManufacturerName ?? '';
                })
                ->addColumn('protocol', function ($row) {
                    return $row->protocol->Title;
                })
                ->addColumn('SampleNo', function ($row) {
                    return 'STB/SAMPLE/' . sprintf('%03d', $row->SampleID);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('system.sample.index');
    }

    public function store(Sample $sample, Request $request)
    {

      //  dd($request);
       
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
