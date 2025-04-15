<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $fields = $request->validate([
            'mobile' => 'required',
            'password' => 'required'
        ]);

        $exists = false;
        $doctor = null;
        if ($fields['mobile']) {
            $doctor = Doctor::where('mobile', $fields['mobile'])->first();
            if ($doctor) {
                $exists = true;
            }
        }
        if (!$exists) {
            return response()->json([
                'status' => false,
                'message' => 'دکتری با چنین مشخصاتی پیدا نشد،لطفا ثبت نام کنید',
                'exists' => true
            ]);
        }
        if (!Hash::check($fields['password'], $doctor->password)) {
            return response()->json([

                'status' => false,
                'message' => 'رمز عبور غلط است'
            ]);
        }
        $token = $doctor->createToken('token_base_name')->plainTextToken;
        return response()->json([
            'status' => true,
            'message' => 'ورود موفقیت آمیز بود',
            'user' => $doctor,
            'Token'=>$token
        ]);
    }

    public function logout(Request $request)
    {

        $request->user()->tokens()->delete();
           return response()->json([
            'status' => true,
            'message' => 'خروج با موفقیت انجام شد'
        ]);
    }
}
