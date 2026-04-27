<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConditionRequest;
use App\Models\Condition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ConditionController extends Controller
{
    public function index(Condition $condition, Request $request)
    {
        if ($request->ajax()) {
            $authUser = Auth::user();

            return DataTables::of($condition->getCondition())
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($authUser) {
                    $editLink = $authUser?->hasPermission('ConditionController@edit') ? route('condition.edit', $row->ConditionID) : null;
                    $deleteLink = $authUser?->hasPermission('ConditionController@delete') ? route('condition.delete', $row->ConditionID) : null;
                    return getDynamicButtonLinkForEditModal($editLink, $deleteLink);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('system.condition.index');
    }

    public function store(Condition $condition, ConditionRequest $request)
    {
        $condition->createCondition($request);

        return $this->success('condition', 'Condition created successfully!');
    }

    public function edit(Condition $condition)
    {
        return view('system.condition.modal.__edit', compact('condition'))->render();
    }

    public function update(Condition $condition, Request $request)
    {
        $condition->updateCondition($condition, $request);

        return $this->success('condition', 'Condition updated successfully!');
    }

    public function delete(Condition $condition)
    {
        $condition->delete();

        return $this->success('condition', 'Condition deleted successfully!');
    }
}
