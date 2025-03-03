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

    // public function create()
    // {
    //     $user = Auth::user();
    //     return view('Panel.RoleDoctor.createRoleDoctor', compact('user'));
    // }

    // public function store(Request $request)
    // {
    //     $user = Auth::user();
    //     $request->validate([
    //         'title' => 'required|unique:doctor_roles,title|max:191',
    //         'quota' => 'required|integer|between:0,100',
    //         'required' => 'required|boolean',
    //         'status' => 'required|boolean',
    //     ]);

    //     DoctorRole::create($request->all());
    //     Alert::success('موفقیت', 'نقش پزشک با موفقیت ایجاد شد');
    //     return redirect()->route('Panel.RolesDoctorList', compact('user'));
    // }

    public function edit($id)
    {
        $user = Auth::user();
        $role = DoctorRole::find($id);
        return view('Panel.RoleDoctor.editRoleDoctor', compact('role', 'user'));
    }

    public function update(Request $request, $id)
    {
        $doctorRole = DoctorRole::find($id);
        
     
        if ($doctorRole->title !== 'جراح') {
    
            $totalOtherQuota = DoctorRole::whereIn('title', ['مشاور', 'بیهوشی'])
                ->where('id', '!=', $id)
                ->sum('quota');
            
           
            $newTotalQuota = $totalOtherQuota + $request->quota;
            
            if ($newTotalQuota > 100) {
                Alert::error('خطا', 'مجموع سهم‌های مشاور و بیهوشی نمی‌تواند بیشتر از 100 درصد باشد');
                return redirect()->back()->withInput();
            }

      
            $oldQuota = $doctorRole->quota;
            
      
            $doctorRole->update($request->all());

        
            $surgeonRole = DoctorRole::where('title', 'جراح')->first();
            if ($surgeonRole) {
           
                if ($request->quota < $oldQuota) {
                    $difference = $oldQuota - $request->quota;
                    $surgeonRole->quota += $difference;
                } 
              
                else {
                    $difference = $request->quota - $oldQuota;
                    $surgeonRole->quota -= $difference;
                }
                $surgeonRole->save();
            }
        } else {
            Alert::error('خطا', 'سهم جراح به صورت خودکار محاسبه می‌شود و قابل تغییر نیست');
            return redirect()->back();
        }

        Alert::success('موفقیت', 'نقش پزشک با موفقیت به‌روزرسانی شد');
        return redirect()->route('Panel.RolesDoctorList');
    }

    // public function destroy($id)
    // {
    //     $role = DoctorRole::find($id);
    //     $role->delete();
    //     Alert::success('موفقیت', 'نقش پزشک با موفقیت حذف شد');
    //     return redirect()->route('Panel.RolesDoctorList');
    // }

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
