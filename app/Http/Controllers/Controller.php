<?php

namespace App\Http\Controllers;

use App\Helpers\HasAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, DispatchesJobs, HasAlert;
}
