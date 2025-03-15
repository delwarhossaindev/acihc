<?php

namespace App\Http\Controllers\System;

use Exception;
use App\Models\StudyType;
use Illuminate\Http\Request;
use App\Models\StudyTypeDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class StudyController extends Controller
{
    public function index(StudyType $study, Request $request)
    {
        if ($request->ajax()) {
            $data = $study->getStudyType();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('details', function ($study) {
                    $StudyTypeMonth = [];
                    foreach ($study->details as $key => $study) {
                        $StudyTypeMonth[$key] = $study->StudyTypeMonth;
                    }
                    return $StudyTypeMonth;
                })
                ->addColumn('action', function ($row) {
                    $editLink = route('studytype.edit', $row->StudyTypeID);
                    $deleteLink = route('studytype.delete', $row->StudyTypeID);
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
        $previousStudyMonth = [];

        foreach ($studytype->details->pluck('StudyTypeMonth') as $key => $month) {
            $previousStudyMonth[$key] = $month;
        }

        $studytype = $studytype->load('details');

        return view('system.studytype.edit', compact('studytype', 'previousStudyMonth'))->render();
    }

    public function update(StudyType $studytype, Request $request)
    {
        $studytype->updateMarket($studytype, $request);

        return $this->success('studytype', 'Study Type updated successfully!');
    }

    public function delete(StudyType $studytype)
    {
        DB::beginTransaction();
        try {
            StudyTypeDetail::where('StudyTypeID', $studytype->StudyTypeID)
                ->delete();
            $studytype->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error('studytype', 'Something went wrong!');
        }

        return $this->success('studytype', 'Study Type deleted successfully!');
    }
}
