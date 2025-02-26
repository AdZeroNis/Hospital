<?php

namespace App\Http\Controllers\Panel;

use App\Models\Insurance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class InsurancesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $insurances = Insurance::all();
        return view('Panel.Insurance.insuranceList', compact('insurances', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        return view('Panel.Insurance.createInsurance', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|max:100|unique:insurances,name',
            'type' => 'required|in:basic,supplementary',
            'discount' => 'required|integer|between:0,100',
            'status' => 'required|boolean',
        ]);

        $data = $request->all();
        Insurance::create($data);

        Alert::success('موفقیت', 'بیمه با موفقیت ایجاد شد');
        return redirect()->route('Panel.InsuranceList', compact('user'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $insurance = Insurance::find($id);
        return view('Panel.Insurance.editInsurance', compact('insurance', 'user'));
    }

    public function update(Request $request, $id)
    {
        $insurance = Insurance::find($id);
        $data = $request->all();

        $request->validate([
            'name' => 'required|max:100|unique:insurances,name,' . $insurance->id,
            'type' => 'required|in:basic,supplementary',
            'discount' => 'required|integer|between:0,100',
            'status' => 'required|boolean',
        ]);

        $insurance->update($data);
        Alert::success('موفقیت', 'بیمه با موفقیت به‌روزرسانی شد');
        return redirect()->route('Panel.InsuranceList');
    }

    public function destroy($id)
    {
        $insurance = Insurance::find($id);
        $insurance->delete();
        Alert::success('موفقیت', 'بیمه با موفقیت حذف شد');
        return redirect()->route('Panel.InsuranceList');
    }

    public function filters(Request $request)
    {
        $user = Auth::user();
        $query = Insurance::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // if ($request->has('type') && $request->type !== '') {
        //     $query->where('type', $request->type);
        // }

        if ($request->has('status') && $request->status !== '') {
            if ($request->status == 'active') {
                $query->where('status', 1);
            } elseif ($request->status == 'inactive') {
                $query->where('status', 0);
            }
        }

        $insurances = $query->get();

        return view('Panel.Insurance.insuranceList', [
            'insurances' => $insurances,
            'search' => $request->search,
            // 'type' => $request->type,
            'status' => $request->status,
            'user' => $user,
        ]);
    }
}
