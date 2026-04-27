<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\StudyType;
use App\Models\StudyTypeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class StudyController extends Controller
{
    public function index(StudyType $study, Request $request)
    {
        if ($request->ajax()) {
            $authUser = Auth::user();

            $query = StudyType::with('details:StudyTypeDetailID,StudyTypeID,StudyTypeMonth')
                ->orderBy('StudyTypeID', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('details', fn ($studyType) => $studyType->details->pluck('StudyTypeMonth')->values()->all())
                ->addColumn('action', function ($row) use ($authUser) {
                    $editLink = $authUser?->hasPermission('StudyController@edit') ? route('studytype.edit', $row->StudyTypeID) : null;
                    $deleteLink = $authUser?->hasPermission('StudyController@delete') ? route('studytype.delete', $row->StudyTypeID) : null;
                    return getDynamicButtonLink($editLink, $deleteLink);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('system.studytype.index');
    }

    public function store(StudyType $study, Request $request)
    {
        $study->createStudyType($request);

        return $this->success('studytype', 'Study Type created successfully!');
    }

    public function edit(StudyType $studytype)
    {
        $studytype->load('details');
        $previousStudyMonth = $studytype->details->pluck('StudyTypeMonth')->values()->all();

        return view('system.studytype.edit', compact('studytype', 'previousStudyMonth'))->render();
    }

    public function update(StudyType $studytype, Request $request)
    {
        $studytype->updateMarket($studytype, $request);

        return $this->success('studytype', 'Study Type updated successfully!');
    }

    public function delete(StudyType $studytype)
    {
        try {
            DB::transaction(function () use ($studytype) {
                StudyTypeDetail::where('StudyTypeID', $studytype->StudyTypeID)->delete();
                $studytype->delete();
            });
        } catch (\Throwable $e) {
            return $this->error('studytype', 'Something went wrong!');
        }

        return $this->success('studytype', 'Study Type deleted successfully!');
    }
}
