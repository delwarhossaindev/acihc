<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use App\Http\Requests\passwordUpdateRequest as UpdatePassword;
use App\Models\User;

class SettingsController extends Controller
{
    public function index(Setting $setting)
    {
        return view('admin.settings.settings.settings',[
            'settings' => $setting->settings()
        ]);
    }

    public function update(Request $request)
    {
        $size = sizeof($request->key);

        $settings = Setting::select('key')->get();

        foreach ($settings as $value) {

            Setting::where('key',$value->key)->update([
                'value' => $request->key[$value->key]
            ]);
        }

        return $this->success('settings','Settings updated successfully'); 
    }

    public function cache()
    {
        Artisan::call('boost:app');

        return $this->success('settings','Cache cleared successfully!'); 
    }

    public function updatePasswordForm()
    {
        return view('admin.settings.settings.updatepassword');       
    }

    public function updatePassword(UpdatePassword $request)
    {
        if(Hash::check($request->old_password , auth()->user()->password)) {
            if(!Hash::check($request->new_password , auth()->user()->password)) {
               $user = User::find(auth()->id());
               $user->update([
                   'password' => bcrypt($request->new_password)
               ]);
               session()->flash('message','Password updated successfully!');
               return redirect()->back();
            }
            session()->flash('message','New password can not be the old password!');
            return redirect()->back();
        }
        session()->flash('message','Old password does not matched!');
        return redirect()->back();
    }
}
