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
            return response()->error(
                'دکتری با چنین مشخصاتی پیدا نشد،لطفا ثبت نام کنید',
                400
            );

        }

        if (!Hash::check($fields['password'], $doctor->password)) {
            return response()->error(
                'رمز ورود غلط است',
                400
            );


        }
        $token = $doctor->createToken('token_base_name')->plainTextToken;
        return response()->success(
            [
                'doctor' => $doctor,
                'token' => $token,
            ],
            'ورود موفقیت آمیز بود'
        );
    }

    public function logout(Request $request)
    {

        $request->user()->tokens()->delete();
        return response()->success(
            'خروج موفقیت آمیز بوئ',
        );
    }
}
