<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DatabaseController extends Controller
{
    public function index(Batch $batch, Request $request)
    {
        if ($request->ajax()) {
            $authUser = Auth::user();

            return DataTables::of(Batch::with('product:ProductID,ProductName'))
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($authUser) {
                    $editLink = $authUser?->hasPermission('DatabaseController@edit') ? route('batch.edit', $row->BatchID) : null;
                    $cloneLink = $authUser?->hasPermission('DatabaseController@clone') ? route('batch.clone', $row->BatchID) : null;
                    $deleteLink = $authUser?->hasPermission('DatabaseController@delete') ? route('batch.delete', $row->BatchID) : null;
                    return batch_button($editLink, $cloneLink, $deleteLink);
                })
                ->addColumn('product', fn ($row) => $row->product->ProductName ?? '')
                ->addColumn('SIDate', function ($row) {
                    if (! $row->SIDate) {
                        return '';
                    }
                    $sidate = (new Carbon($row->SIDate))->subMonths((int) $row->Month);
                    return $sidate->toFormattedDateString();
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('system.database.index');
    }
}
