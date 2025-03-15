<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.user.profile');
    }

    public function update(User $user, ProfileUpdateRequest $request)
    {   
        $user->updateProfile($user, $request)
            ->saveAddress($request);
        
        return $this->success('profile','Profile updated successfully!');
    }
}
