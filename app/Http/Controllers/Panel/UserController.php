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
   public function UserList()
   {
     $users = User::all();
      return view('Panel.User.userList',compact('users'));
   }
   public function Store()
   {
     $user = Auth::user();
      return view('Panel.User.createUser',compact('user'));
   }
   public function Save(Request $request)
   {
    $user = Auth::user();
    $data=$request->all();
    User::create($data);
    Alert::success('موفقیت', 'کاربر با موفقعیت اضاف شد');
    return redirect()->route('Panel.UserList',compact('user'));
   }
   public function Edit($id)
   {

     $user = User::find($id);
      return view('Panel.User.editUser',compact('user'));
   }

   public function Update(Request $request,$id)
   {

       $user = User::find($id);
       $data = $request->all();

        $user->update($data);
        Alert::success('موفقیت', 'کاربر با موفقعیت ویرایش شد');
         return redirect()->route('Panel.UserList');

   }
   public function Delete($id)
   {

     $user = User::find($id);
     $user->delete();
     Alert::success('موفقیت', 'کاربر با موفقیت حذف شد');
     return redirect()->route('Panel.UserList');
   }
}
