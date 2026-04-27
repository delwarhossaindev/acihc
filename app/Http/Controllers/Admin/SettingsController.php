<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\passwordUpdateRequest as UpdatePassword;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index(Setting $setting)
    {
        return view('admin.settings.settings.settings', [
            'settings' => $setting->settings(),
        ]);
    }

    public function update(Request $request)
    {
        $keys = (array) $request->key;

        DB::transaction(function () use ($keys) {
            foreach ($keys as $key => $value) {
                Setting::where('key', $key)->update(['value' => $value]);
                Cache::forget("system_setting:{$key}");
            }
        });

        return $this->success('settings', 'Settings updated successfully');
    }

    public function cache()
    {
        Artisan::call('boost:app');

        return $this->success('settings', 'Cache cleared successfully!');
    }

    public function updatePasswordForm()
    {
        return view('admin.settings.settings.updatepassword');
    }

    public function updatePassword(UpdatePassword $request)
    {
        $user = Auth::user();

        if (! $user || ! Hash::check($request->old_password, $user->password)) {
            session()->flash('message', 'Old password does not matched!');
            return redirect()->back();
        }

        if (Hash::check($request->new_password, $user->password)) {
            session()->flash('message', 'New password can not be the old password!');
            return redirect()->back();
        }

        User::where('id', $user->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        session()->flash('message', 'Password updated successfully!');

        return redirect()->back();
    }
}
