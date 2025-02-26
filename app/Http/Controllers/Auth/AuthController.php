<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function FormLogin()
    {
        return view('Auth.login.login');
    }
    public function Login(Request $request)
    {
        $request->validate([
            'mobile'=>'required',
            'password'=>'required',
        ]);
      $user = User::where("mobile", $request->mobile)->first();
      if ($user && Hash::check($request->password, $user->password))
      {
        Auth::login($user);
        return redirect()->route('Panel');
      }
      else
      {
        return back()->with('error', 'User not found!');
      }
    }
}
