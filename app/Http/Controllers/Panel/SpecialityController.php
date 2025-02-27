<?php

namespace App\Http\Controllers\Panel;

use App\Models\Speciality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SpecialityController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $specialities = Speciality::all();
        return view('Panel.Speciality.SpecialitiesList', compact('specialities','user'));
    }

    public function create()
    {
        $user = Auth::user();
        return view('Panel.Speciality.createSpecialities', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'title' => 'required|unique:specialities,title|max:191',
            'status' => 'required|boolean',
        ]);

        Speciality::create($request->all());
        Alert::success('موفقیت', 'تخصص جدید با موفقیت اضافه شد');
        return redirect()->route('Panel.SpecialitiesList',compact('user'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $speciality = Speciality::find($id);
        return view('Panel.Speciality.editSpecialities', compact('speciality','user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:191|unique:specialities,title,' . $id,
            'status' => 'required|boolean',
        ]);

        $speciality = Speciality::find($id);
        $speciality->update($request->all());
        Alert::success('موفقیت', 'تخصص با موفقیت ویرایش شد');
        return redirect()->route('Panel.SpecialitiesList');
    }

    public function destroy($id)
    {
        $speciality = Speciality::find($id);

        // if ($speciality->doctors()->exists()) {
        //     Alert::error('نا موفق', 'تخصص قابل  حذف نیست');
        // return redirect()->route('Panel.SpecialitiesList');
        // }

        $speciality->delete();
        Alert::success('موفقیت', 'تخصص با موفقیت حذف شد');
        return redirect()->route('Panel.SpecialitiesList');
    }

    public function filters(Request $request)
    {
        $user = Auth::user();
        $query =  Speciality::query();

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

        $specialities = $query->get();

        return view('Panel.Speciality.SpecialitiesList', [
            'specialities' => $specialities,
            'search' => $request->search,
            'status' => $request->status,
            'user' => $user,
        ]);
    }
}
