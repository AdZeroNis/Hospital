<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{




    public function Profile()
    {

        $user = Auth::user();


        if (!$user) {
            return redirect()->route('Profile')->with('error', 'User not found');
        }


        return view('Admin.User.profile', compact('user'));
    }
    public function Edit($id)
    {

        $user = User::find($id);
        return view('Admin.User.editUser', compact('user'));
    }
    public function Update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('Profile')->with('error', 'User not found');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'required_with:password', // اضافه کردن اعتبارسنجی رمز فعلی
            'password' => 'nullable|min:6|confirmed',
        ]);

        // اعتبارسنجی رمز عبور فعلی
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                Alert::error('خطا', 'رمز عبور فعلی نادرست است');
                return redirect()->back();
            }
        }

        $dataForm = $request->except(['password', 'current_password']);

        if ($request->filled('password')) {
            $dataForm['password'] = Hash::make($request->password);
        }

        $user->update($dataForm);

        // اگر رمز تغییر کرده باشد، کاربر را لاگ اوت می‌کنیم
        if ($request->filled('password')) {
            Auth::logout();
            Alert::success('موفقیت', 'پروفایل و رمز عبور با موفقیت به‌روزرسانی شد. لطفاً مجدداً وارد شوید');
            return redirect()->route('FormLogin');
        }

        Alert::success('موفقیت', 'پروفایل با موفقیت به‌روزرسانی شد');
        return redirect()->route('Profile');
    }
}
