<?php

namespace App\Http\Controllers\Panel;

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


        return view('Panel.User.profile', compact('user'));
    }
           public function Edit($id)
       {

         $user = User::find($id);
          return view('Panel.User.editUser',compact('user'));
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
               'password' => 'nullable|min:6|confirmed',
           ]);

           $dataForm = $request->except(['password']);

           if ($request->filled('password')) {
               $dataForm['password'] = Hash::make($request->password);
           }

           $user->update($dataForm);

           Alert::success('موفقیت', 'پروفایل با موفقیت به‌روزرسانی شد');
           return redirect()->route('Profile');
       }


}
