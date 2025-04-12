<?php

namespace App\Http\Controllers\Admin;

use App\Models\Doctor;
use App\Models\Speciality;
use App\Models\DoctorRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class DoctorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $doctors = Doctor::latest()->get();
        return view('Admin.Doctor.doctoList', compact('doctors', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        $specialities = Speciality::all();
        $doctor_roles = DoctorRole::all();
        return view('Admin.Doctor.createDoctor', compact('specialities', 'user', 'doctor_roles'));
    }

    public function store(Request $request)
    {
        if (Doctor::where('national_code', $request->national_code)->exists()) {
            Alert::error('خطا', 'این پزشک قبلاً در سیستم ثبت شده است');
            return redirect()->back()->withInput();
        }

        $request->validate([
            'name' => 'required|max:100',
            'speciality_id' => 'required|exists:specialities,id',
            'national_code' => 'nullable|max:20',
            'medical_number' => 'nullable|max:191',
            'mobile' => 'required|unique:doctors,mobile|max:20',
            'password' => 'required|max:191|confirmed',
            'status' => 'required|boolean',
            'Doctor_roles' => 'required|array'
        ]);

        $data = $request->only(['name', 'speciality_id', 'national_code', 'medical_number', 'mobile', 'status']);
        if ($request->filled('password')) {
            $dataForm['password'] = Hash::make($request->password);
        }
        $data['password'] = Hash::make($request->password);

        $doctor = Doctor::create($data);


        $doctor->roles()->attach($request->Doctor_roles);

        Alert::success('موفقیت', 'پزشک با موفقیت ایجاد شد');
        return redirect()->route('Panel.DoctorList');
    }


    public function edit($id)
    {
        $user = Auth::user();
        $doctor = Doctor::find($id);
        $specialities = Speciality::all();
        $doctor_roles = DoctorRole::all();
        return view('Admin.Doctor.editDoctor', compact('doctor', 'specialities', 'user', 'doctor_roles'));
    }

    public function update(Request $request, $id)
    {
        if (Doctor::where('national_code', $request->national_code)->where('id', '!=', $id)->exists()) {
            Alert::error('خطا', 'این پزشک قبلاً در سیستم ثبت شده است');
            return redirect()->back()->withInput();
        }

        $request->validate([
            'name' => 'required|max:100',
            'speciality_id' => 'required|exists:specialities,id',
            'national_code' => 'nullable|max:20',
            'medical_number' => 'nullable|max:191',
            'mobile' => 'required|unique:doctors,mobile,' . $id . '|max:20',
            'password' => 'nullable|max:191|confirmed',
            'status' => 'required|boolean',
            'Doctor_roles' => 'required|array'
        ]);

        $data = $request->only(['name', 'speciality_id', 'national_code', 'medical_number', 'mobile', 'status']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $doctor = Doctor::find($id);
        $doctor->update($data);

        $doctor->roles()->sync($request->Doctor_roles);

        Alert::success('موفقیت', 'پزشک با موفقیت به‌روزرسانی شد');
        return redirect()->route('Panel.DoctorList');
    }

    public function destroy($id)
    {

        $doctor = Doctor::find($id);
        $doctor->roles()->detach();
        $doctor->delete();

        Alert::success('موفقیت', 'پزشک با موفقیت حذف شد');

        return redirect()->route('Panel.DoctorList');
    }

    public function filters(Request $request)
    {
        $user = Auth::user();
        $query = Doctor::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status !== '') {
            if ($request->status == 'active') {
                $query->where('status', 1);
            } elseif ($request->status == 'inactive') {
                $query->where('status', 0);
            }
        }

        $doctors = $query->get();

        return view('Admin.Doctor.doctoList', [
            'doctors' => $doctors,
            'search' => $request->search,
            'status' => $request->status,
            'user' => $user,
        ]);
    }

    public function details($id)
    {
        $user = Auth::user();
        $doctor = Doctor::with(['roles', 'speciality', 'surgeries.operations'])->find($id);

        // Calculate total amount and prepare surgeries data
        $totalAmount = $doctor->surgeries->sum(function ($surgery) use ($doctor) {
            return $surgery->doctors->where('id', $doctor->id)->first()->pivot->amount;
        });

        // Prepare surgeries data with role information
        $surgeries = $doctor->surgeries->map(function ($surgery) use ($doctor) {
            $role = $surgery->doctors->where('id', $doctor->id)->first()->pivot->doctor_role_id;
            $roleName = $doctor->roles->where('id', $role)->first()->title;
            $amount = $surgery->doctors->where('id', $doctor->id)->first()->pivot->amount;
            $surgeriedAt = \Morilog\Jalali\Jalalian::fromDateTime($surgery->surgeried_at)->format('Y/m/d');

            return [
                'patient_name' => $surgery->patient_name,
                'operations' => $surgery->operations,
                'role_name' => $roleName,
                'amount' => $amount,
                'surgeried_at' => $surgeriedAt
            ];
        });

        return view('Admin.Doctor.details_doctor', compact('doctor', 'user', 'surgeries', 'totalAmount'));
    }
}
