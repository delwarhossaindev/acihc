<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManufacturerRequest;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ManufacturerController extends Controller
{
    public function index(Manufacturer $manufacturer, Request $request)
    {
        if ($request->ajax()) {
            $authUser = Auth::user();

            return DataTables::of(Manufacturer::with('address'))
                ->addIndexColumn()
                ->addColumn('address1', fn ($m) => $m->address?->address_line_1)
                ->addColumn('address2', fn ($m) => $m->address?->address_line_2)
                ->addColumn('type', fn ($m) => $m->address?->address_type)
                ->addColumn('city', fn ($m) => $m->address?->city)
                ->addColumn('phone', fn ($m) => $m->address?->phone)
                ->addColumn('zip_code', fn ($m) => $m->address?->zip_code)
                ->addColumn('email', fn ($m) => $m->address?->email)
                ->addColumn('action', function ($row) use ($authUser) {
                    $editLink = $authUser?->hasPermission('ManufacturerController@edit') ? route('manufacturer.edit', $row->ManufacturerID) : null;
                    $deleteLink = $authUser?->hasPermission('ManufacturerController@delete') ? route('manufacturer.delete', $row->ManufacturerID) : null;
                    return getDynamicButtonLinkForEditModal($editLink, $deleteLink);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('system.manufacturer.index');
    }

    public function store(Manufacturer $manufacturer, ManufacturerRequest $request)
    {
        $manufacturer->createManufacturer($request)
            ->saveAddress($request);

        return $this->success('manufacturer', 'Manufacturer created successfully!');
    }

    public function edit(Manufacturer $manufacturer)
    {
        $manufacturer->load('address');

        return view('system.manufacturer.modal.__edit', compact('manufacturer'))->render();
    }

    public function update(Manufacturer $manufacturer, Request $request)
    {
        $manufacturer->updateManufacturer($manufacturer, $request)
            ->saveAddress($request);

        return $this->success('manufacturer', 'Manufacturer updated successfully!');
    }

    public function delete(Manufacturer $manufacturer)
    {
        $manufacturer->delete();

        return $this->success('manufacturer', 'Manufacturer deleted successfully!');
    }
}
