<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {  
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {   
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();
            return $this->success('dashboard', 'You are successfully logged in!');
        }
        
        return $this->error('login', 'You credentials is not matched!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return $this->success('login','You are successfully logged out!');
    }
}
