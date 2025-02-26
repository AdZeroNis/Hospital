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

    public function create()
    {
        $user = Auth::user();
        return view('Panel.RoleDoctor.createRoleDoctor',compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'title' => 'required|unique:roles_doctor,title|max:191',
            'quota' => 'required|integer|between:0,100',
            'status' => 'required|boolean',
        ]);

        DoctorRole::create($request->all());
        Alert::success('Success', 'Doctor role created successfully');
        return redirect()->route('Panel.RolesDoctorList',compact('user'));
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
        $data = $request->all();

        $doctorRole->update($data);
        Alert::success('Success', 'Doctor role updated successfully');
        return redirect()->route('Panel.RolesDoctorList');
    }

    public function destroy($id)
    {
        $role = DoctorRole::find($id);
        $role->delete();
        Alert::success('Success', 'Doctor role deleted successfully');
        return redirect()->route('Panel.RolesDoctorList');
    }
    public function filters(Request $request)
    {
        $user = Auth::user();
        $query =  DoctorRole::query();

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
            'user' => $user,
        ]);
    }
}
