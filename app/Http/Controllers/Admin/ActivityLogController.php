<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $data =  userActivityLog();
        
        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

       return view('admin.activity.log');
    }
}
