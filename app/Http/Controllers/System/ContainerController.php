<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Container;
use App\Models\ContainerPackaging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ContainerController extends Controller
{
    public function index(Container $container, Request $request)
    {
        if ($request->ajax()) {
            $authUser = Auth::user();

            return DataTables::of($container->getContainer())
                ->addIndexColumn()
                ->addColumn('PackagingName', fn ($c) => $c->packaging->pluck('PackagingName')->values()->all())
                ->addColumn('PackagingSource', fn ($c) => $c->packaging->pluck('PackagingSource')->values()->all())
                ->addColumn('action', function ($row) use ($authUser) {
                    $editLink = $authUser?->hasPermission('ContainerController@edit') ? route('container.edit', $row->ContainerID) : null;
                    $deleteLink = $authUser?->hasPermission('ContainerController@delete') ? route('container.delete', $row->ContainerID) : null;
                    return getDynamicButtonLink($editLink, $deleteLink);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('system.container.index');
    }

    public function create()
    {
        return view('system.container.create');
    }

    public function store(Container $container, Request $request)
    {
        $container->createContainer($request);

        return $this->success('container', 'Container created successfully!');
    }

    public function edit(Container $container)
    {
        $container->load('packaging');

        return view('system.container.edit', compact('container'));
    }

    public function update(Container $container, Request $request)
    {
        $container->updateContainer($container, $request);

        return $this->success('container', 'Container updated successfully!');
    }

    public function delete(Container $container)
    {
        DB::transaction(function () use ($container) {
            ContainerPackaging::where('ContainerID', $container->ContainerID)->delete();
            $container->delete();
        });

        return $this->success('container', 'Container deleted successfully!');
    }
}
