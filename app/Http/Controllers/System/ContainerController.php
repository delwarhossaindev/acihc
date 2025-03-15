<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Container;
use App\Models\ContainerPackaging;
use Yajra\DataTables\Facades\DataTables;

class ContainerController extends Controller
{
    public function index(Container $container, Request $request)
    {
        if ($request->ajax()) {
            $data = $container->getContainer();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('PackagingName', function ($container) {
                    $PackagingName = [];
                    foreach ($container->packaging as $key => $packaging) {
                        $PackagingName[$key] = $packaging->PackagingName;
                    }
                    return $PackagingName;
                })
                ->addColumn('PackagingSource', function ($container) {
                    $PackagingSource = [];
                    foreach ($container->packaging as $key => $packaging) {
                        $PackagingSource[$key] = $packaging->PackagingSource;
                    }
                    return $PackagingSource;
                })
                ->addColumn('action', function ($row) {
                    $editLink = route('container.edit', $row->ContainerID);
                    $deleteLink = route('container.delete', $row->ContainerID);
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
        $container = $container->load('packaging');

        return view('system.container.edit', compact('container'));
    }

    public function update(Container $container, Request $request)
    {
        $container->updateContainer($container, $request);

        return $this->success('container', 'Container updated successfully!');
    }

    public function delete(Container $container)
    {
        ContainerPackaging::where('ContainerID', $container->ContainerID)
            ->delete();

        $container->delete();

        return $this->success('container', 'Container deleted successfully!');
    }
}
