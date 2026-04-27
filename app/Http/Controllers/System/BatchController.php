<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Condition;
use App\Models\Protocol;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BatchController extends Controller
{
    public function index(Batch $batch, Request $request)
    {
        if ($request->ajax()) {
            $authUser = Auth::user();

            return DataTables::of(Batch::with('product:ProductID,ProductName'))
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($authUser) {
                    $editLink = $authUser?->hasPermission('BatchController@edit') ? route('batch.edit', $row->BatchID) : null;
                    $deleteLink = $authUser?->hasPermission('BatchController@delete') ? route('batch.delete', $row->BatchID) : null;
                    return batch_button($editLink, '', $deleteLink);
                })
                ->addColumn('Product', fn ($row) => $row->product->ProductName ?? '')
                ->addColumn('SIDate', fn ($row) => $row->SIDate ? Carbon::parse($row->SIDate)->toFormattedDateString() : '')
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('system.batch.index');
    }

    public function create()
    {
        return view('system.batch.create', [
            'protocols' => Protocol::with('product:ProductID,ProductName')->get(),
            'condition' => Condition::get(),
        ]);
    }

    public function store(Batch $batch, Request $request)
    {
        $batch->createBatch($request);

        return $this->success('batch.index', 'Batch created successfully!');
    }

    public function edit(Batch $batch)
    {
        $protocols = Protocol::with('product:ProductID,ProductName')->get();
        $condition = Condition::get();

        $protocol = Protocol::with('statbilityStudy.study.details')
            ->where('ProtocolID', $batch->ProtocolID)
            ->first();

        $availableMonths = collect();
        if ($protocol) {
            $availableMonths = $protocol->statbilityStudy
                ->flatMap(fn ($stability) => $stability->study?->details?->pluck('StudyTypeMonth') ?? collect())
                ->unique()
                ->values();
        }

        $batchDetails = $batch->batchDetails;

        return view('system.batch.edit', compact('batch', 'protocols', 'availableMonths', 'batchDetails', 'condition'));
    }

    public function update(Batch $batch, Request $request)
    {
        $batch->updateBatch($batch, $request);

        return $this->success('batch.index', 'Batch updated successfully!');
    }

    public function delete(Batch $batch)
    {
        $batch->delete();

        return $this->success('batch.index', 'Batch deleted successfully!');
    }

    public function clone(Batch $batch)
    {
        $SIDate = Batch::where('BatchNo', $batch->BatchNo)
            ->orderBy('Month', 'asc')
            ->value('SIDate');

        $protocols = Protocol::with('product:ProductID,ProductName')->get();

        return view('system.batch.create', compact('protocols', 'batch', 'SIDate'));
    }
}
