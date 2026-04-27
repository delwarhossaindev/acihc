<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\MarketCreateRequest;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MarketController extends Controller
{
    public function index(Market $market, Request $request)
    {
        if ($request->ajax()) {
            $authUser = Auth::user();

            return DataTables::of($market->getMarket())
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($authUser) {
                    $editLink = $authUser?->hasPermission('MarketController@edit') ? route('market.edit', $row->MarketID) : null;
                    $deleteLink = $authUser?->hasPermission('MarketController@delete') ? route('market.delete', $row->MarketID) : null;
                    return getDynamicButtonLinkForEditModal($editLink, $deleteLink);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('system.market.index');
    }

    public function store(Market $market, MarketCreateRequest $request)
    {
        $market->createMarket($request);

        return $this->success('market', 'Market created successfully!');
    }

    public function edit(Market $market)
    {
        return view('system.market.modal.__edit', compact('market'))->render();
    }

    public function update(Market $market, Request $request)
    {
        $market->updateMarket($market, $request);

        return $this->success('market', 'Market updated successfully!');
    }

    public function delete(Market $market)
    {
        $market->delete();

        return $this->success('market', 'Market deleted successfully!');
    }
}
