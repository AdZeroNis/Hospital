<?php

namespace App\Http\Controllers\Panel;

use App\Models\Surgery;
use App\Models\Insurance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Doctor;
use App\Models\DoctorRole;

class SurgeryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $surgeries = Surgery::all();
        return view('Panel.Surgery.surgeryList', compact('surgeries', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        $insurances = Insurance::all();
        $doctors = Doctor::all();
        return view('Panel.Surgery.createSurgery', compact('user', 'insurances', 'doctors'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        try {
            $request->validate([
                'patient_name' => 'required|max:100',
                'patient_national_code' => 'required|max:20',
                'basic_insurance_id' => 'nullable|exists:insurances,id',
                'supp_insurance_id' => 'nullable|exists:insurances,id',
                'document_number' => 'required|unique:surgeries,document_number',
                'surgeried_at' => 'required|date',
                'released_at' => 'required|date',
                'surgeon_id' => 'required|exists:doctors,id',
                'anesthesiologist_id' => 'required|exists:doctors,id',
                'consultant_id' => 'nullable|exists:doctors,id',
            ]);

            // Check if the same doctor is selected for multiple roles
            if ($request->surgeon_id == $request->anesthesiologist_id) {
                Alert::error('خطا', 'یک پزشک نمی‌تواند همزمان جراح و متخصص بیهوشی باشد');
                return back()->withInput();
            }

            if ($request->consultant_id) {
                if ($request->surgeon_id == $request->consultant_id) {
                    Alert::error('خطا', 'یک پزشک نمی‌تواند همزمان جراح و مشاور باشد');
                    return back()->withInput();
                }
                if ($request->anesthesiologist_id == $request->consultant_id) {
                    Alert::error('خطا', 'یک پزشک نمی‌تواند همزمان متخصص بیهوشی و مشاور باشد');
                    return back()->withInput();
                }
            }

            $data = $request->all();
            $surgery = Surgery::create($data);
            Alert::success('موفقیت', 'عمل جراحی با موفقیت ایجاد شد');
            return redirect()->route('Panel.SurgeryList', compact('user'));

        } catch (\Illuminate\Validation\ValidationException $e) {
            Alert::error('خطا', 'لطفاً تمام فیلدهای الزامی را پر کنید');
            return back()->withInput();
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        $surgery = Surgery::find($id);
        $insurances = Insurance::all();
        return view('Panel.Surgery.editSurgery', compact('surgery', 'user', 'insurances'));
    }

    public function update(Request $request, $id)
    {
        $surgery = Surgery::find($id);

       
        $request->validate([
            'patient_name' => 'required|max:100',
            'patient_national_code' => 'required|max:20',
            'basic_insurance_id' => 'nullable|exists:insurances,id',
            'supp_insurance_id' => 'nullable|exists:insurances,id',
            'document_number' => 'required|unique:surgeries,document_number,' . $surgery->id,
            'surgeried_at' => 'required|date',
            'released_at' => 'required|date',
        ]);

        $data = $request->all();

        if ($request->has('supp_insurance_id') && $request->supp_insurance_id != null) {
            $data['basic_insurance_id'] = null;
        }

        $surgery->update($data);

        Alert::success('موفقیت', 'عمل جراحی با موفقیت ویرایش شد');
        return redirect()->route('Panel.SurgeryList');
    }


    public function destroy($id)
    {
        $surgery = Surgery::find($id);
        $surgery->delete();

        Alert::success('موفقیت', 'عمل جراحی با موفقیت حذف شد');
        return redirect()->route('Panel.SurgeryList');
    }

    public function filters(Request $request)
    {
        $user = Auth::user();
        $query = Surgery::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('patient_name', 'like', '%' . $request->search . '%')
                  ->orWhere('patient_national_code', 'like', '%' . $request->search . '%');
        }

        $surgeries = $query->get();

        return view('Panel.Surgery.surgeryList', [
            'surgeries' => $surgeries,
            'search' => $request->search,
            'status' => $request->status,
            'user' => $user,
        ]);
    }
}
