<?php

namespace App\Http\Controllers\System;

use App\Models\Manufacturer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ManufacturerRequest;
use Yajra\DataTables\Facades\DataTables;

class ManufacturerController extends Controller
{
    public function index(Manufacturer $manufacturer, Request $request)
    {
        if ($request->ajax()) {
            $data = $manufacturer->getManufacturer();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('address1', function ($manufacturer) {
                    return $manufacturer->address->address_line_1;
                })
                ->addColumn('address2', function ($manufacturer) {
                    return $manufacturer->address->address_line_2;
                })
                ->addColumn('type', function ($manufacturer) {
                    return $manufacturer->address->address_type;
                })
                ->addColumn('city', function ($manufacturer) {
                    return $manufacturer->address->city;
                })
                ->addColumn('phone', function ($manufacturer) {
                    return $manufacturer->address->phone;
                })
                ->addColumn('zip_code', function ($manufacturer) {
                    return $manufacturer->address->zip_code;
                })
                ->addColumn('email', function ($manufacturer) {
                    return $manufacturer->address->email;
                })
                ->addColumn('action', function ($row) {
                    $editLink = route('manufacturer.edit', $row->ManufacturerID);
                    $deleteLink = route('manufacturer.delete', $row->ManufacturerID);
                    return getDynamicButtonLinkForEditModal($editLink, $deleteLink);
                })
                // ->addColumn('checkbox', function ($row) {
                //     return '<input type="checkbox" id="'.$row->ManufacturerID.'" name="checkbox" class="form-check-input"/>';
                //   })
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
        $manufacturer = $manufacturer->load('address');

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
