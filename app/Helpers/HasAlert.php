<?php 

namespace App\Helpers;

trait HasAlert
{
    public function success(string $route, string $message)
    {   
        return redirect()->route($route)->with('message',$message);
    }

    public function error(string $route, string $message)
    {
        return redirect()->route($route)->with('error',$message);
    }
}