<?php

namespace App\Http\Controllers\Panel;

use App\Models\DoctorRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DoctorRoleController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roles = DoctorRole::all();
        return view('Panel.RoleDoctor.roleDoctorList', compact('roles', 'user'));
    }


    public function edit($id)
    {
        $user = Auth::user();
        $role = DoctorRole::find($id);
        return view('Panel.RoleDoctor.editRoleDoctor', compact('role', 'user'));
    }

    public function update(Request $request, $id)
    {
        $doctorRole = DoctorRole::find($id);

      

        // محاسبه مجموع سهم‌های مشاور و بیهوشی (به جز رکورد فعلی)
        $totalOtherQuota = DoctorRole::whereIn('title', ['مشاور', 'بیهوشی'])
            ->where('id', '!=', $id)
            ->sum('quota');

        // محاسبه مجموع جدید در صورت اعمال تغییرات
        $newTotalQuota = $totalOtherQuota + $request->quota;

        // اگر مجموع فعلی ۱۰۰% است، فقط کاهش مجاز است
        if (($totalOtherQuota + $doctorRole->quota) >= 100 && $request->quota > $doctorRole->quota) {
            Alert::error('خطا', 'در حال حاضر مجموع سهم‌ها ۱۰۰% است. فقط می‌توانید سهم را کاهش دهید');
            return redirect()->back()->withInput();
        }

        // اگر مجموع جدید از ۱۰۰% بیشتر شود، خطا نمایش داده شود
        if ($newTotalQuota > 100) {
            Alert::error('خطا', 'مجموع سهم‌های مشاور و بیهوشی نمی‌تواند بیشتر از ۱۰۰٪ باشد');
            return redirect()->back()->withInput();
        }

        // بروزرسانی سهم
        $doctorRole->update(['quota' => $request->quota]);

        Alert::success('موفقیت', 'سهم با موفقیت به‌روزرسانی شد');
        return redirect()->route('Panel.RolesDoctorList');
    }


    public function filters(Request $request)
    {
        $user = Auth::user();
        $query = DoctorRole::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status !== '') {
            if ($request->status == 'active') {
                $query->where('status', 1);
            } elseif ($request->status == 'inactive') {
                $query->where('status', 0);
            }
        }

        $roles = $query->get();

        return view('Panel.RoleDoctor.roleDoctorList', [
            'roles' => $roles,
            'search' => $request->search,
            'status' => $request->status,
            'required' => $request->required,
            'user' => $user,
        ]);
    }
}
