<?php

namespace App\Http\Controllers\Panel;

use App\Models\Doctor;
use App\Models\Speciality;
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
        $doctors = Doctor::all();
        return view('Panel.Doctor.doctoList', compact('doctors', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        $specialities = Speciality::all();
        return view('Panel.Doctor.createDoctor', compact('specialities', 'user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|max:100',
            'speciality_id' => 'required|exists:specialities,id',
            'national_code' => 'nullable|max:20',
            'medical_number' => 'nullable|max:191',
            'mobile' => 'required|unique:doctors,mobile|max:20',
            'password' => 'required|max:191',
            'status' => 'required|boolean',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        Doctor::create($data);
        Alert::success('موفقیت', 'پزشک با موفقیت ایجاد شد');
        return redirect()->route('Panel.DoctorList', compact('user'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $doctor = Doctor::find($id);
        $specialities = Speciality::all();
        return view('Panel.Doctor.editDoctor', compact('doctor', 'specialities', 'user'));
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::find($id);
        $data = $request->all();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $doctor->update($data);
        Alert::success('موفقیت', 'پزشک با موفقیت به‌روزرسانی شد');
        return redirect()->route('Panel.DoctorList');
    }

    public function destroy($id)
    {
        $doctor = Doctor::find($id);
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

        return view('Panel.Doctor.doctoList', [
            'doctors' => $doctors,
            'search' => $request->search,
            'status' => $request->status,
            'user' => $user,
        ]);
    }
}
