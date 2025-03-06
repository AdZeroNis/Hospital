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
use Hekmatinasser\Verta\Verta;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\DB;
use App\Models\Operation;



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
        $operations = Operation::all();
        $doctor_roles = DoctorRole::all();
        return view('Panel.Surgery.createSurgery', compact('user', 'insurances', 'doctors', 'operations', 'doctor_roles'));
    }
    public function store(Request $request)
    {
        if (Surgery::where('patient_national_code', $request->patient_national_code)->exists()) {
            Alert::error('خطا', 'این بیمار قبلاً در سیستم ثبت شده است');
            return redirect()->back()->withInput();
        }

        if ($request->surgeon_id == $request->anesthesiologist_id) {
            Alert::error('خطا', 'جراح و متخصص بیهوشی نمی‌توانند یک نفر باشند');
            return redirect()->back()->withInput();
        }

        if ($request->filled('consultant_id')) {
            if ($request->consultant_id == $request->surgeon_id || $request->consultant_id == $request->anesthesiologist_id) {
                Alert::error('خطا', 'مشاور نمی‌تواند با جراح یا متخصص بیهوشی یک نفر باشند');
                return redirect()->back()->withInput();
            }
        }

        $request->validate([
            'patient_name' => 'required|string',
            'patient_national_code' => 'required|string|max:20',
            'operations' => 'required|array',
            'operations.*' => 'exists:operations,id',
            'basic_insurance_id' => 'nullable|exists:insurances,id',
            'supp_insurance_id' => 'nullable|exists:insurances,id',
            'document_number' => 'required|integer|unique:surgeries',
            'surgeried_at' => 'required|string', // تغییر به string
            'released_at' => 'required|string', // تغییر به string
            'description' => 'nullable|string',
            'surgeon_id' => 'required|exists:doctors,id',
            'anesthesiologist_id' => 'required|exists:doctors,id',
            'consultant_id' => 'nullable|exists:doctors,id'
        ]);
        $surgeried_at = Jalalian::fromFormat('Y/m/d', $request->surgeried_at)->toCarbon();
        $released_at = Jalalian::fromFormat('Y/m/d', $request->released_at)->toCarbon();



        $surgery = Surgery::create([
            'patient_name' => $request->patient_name,
            'patient_national_code' => $request->patient_national_code,
            'basic_insurance_id' => $request->basic_insurance_id,
            'supp_insurance_id' => $request->supp_insurance_id,
            'document_number' => $request->document_number,
            'surgeried_at' => $surgeried_at, // ذخیره به صورت میلادی
            'released_at' => $released_at, // ذخیره به صورت میلادی
            'description' => $request->description,
        ]);

        // محاسبه مبلغ کل عملیات‌ها
        $total_amount = 0;
        foreach ($request->operations as $operation_id) {
            $operation = Operation::find($operation_id);
            $total_amount += $operation->price;
            $surgery->operations()->attach($operation_id, ['amount' => $operation->price]);
        }

        // گرفتن سهم جراح
        $surgeon = Doctor::find($request->surgeon_id);
        $surgeon_role = $surgeon->roles->where('id', 1)->first();
        $surgeon_share = ($surgeon_role->quota / 100) * $total_amount;

        // گرفتن سهم بیهوشی
        $anesthesiologist = Doctor::find($request->anesthesiologist_id);
        $anesthesiologist_role = $anesthesiologist->roles->where('id', 2)->first();
        $anesthesiologist_share = ($anesthesiologist_role->quota / 100) * $total_amount;

        // گرفتن سهم مشاور (در صورت وجود)
        $consultant_share = 0;
        if ($request->filled('consultant_id')) {
            $consultant = Doctor::find($request->consultant_id);
            $consultant_role = $consultant->roles->where('id', 3)->first();
            $consultant_share = ($consultant_role->quota / 100) * $total_amount;
        }

        // ذخیره سهم پزشکان در جدول پیوت
        $surgery->doctors()->attach($request->surgeon_id, ['doctor_role_id' => 1, 'amount' => $surgeon_share]);
        $surgery->doctors()->attach($request->anesthesiologist_id, ['doctor_role_id' => 2, 'amount' => $anesthesiologist_share]);

        if ($request->filled('consultant_id')) {
            $surgery->doctors()->attach($request->consultant_id, ['doctor_role_id' => 3, 'amount' => $consultant_share]);
        }


        Alert::success('موفقیت', 'عمل جراحی با موفقیت ثبت شد');
        return redirect()->route('Panel.SurgeryList');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $surgery = Surgery::find($id);
        $insurances = Insurance::all();
        $doctors = Doctor::all();
        $operations = Operation::all();

        // تبدیل تاریخ‌های میلادی به شمسی
        $surgeried_at = Jalalian::fromDateTime($surgery->surgeried_at)->format('Y/m/d');
        $released_at = Jalalian::fromDateTime($surgery->released_at)->format('Y/m/d');

        return view('Panel.Surgery.editSurgery', compact('surgery', 'user', 'insurances', 'doctors', 'operations', 'surgeried_at', 'released_at'));
    }

    public function update(Request $request, $id)
    {
        // بررسی تکراری نبودن پزشکان در نقش‌های مختلف
        if ($request->surgeon_id == $request->anesthesiologist_id) {
            Alert::error('خطا', 'جراح و متخصص بیهوشی نمی‌توانند یک نفر باشند');
            return redirect()->back()->withInput();
        }

        if ($request->filled('consultant_id')) {
            if ($request->consultant_id == $request->surgeon_id || $request->consultant_id == $request->anesthesiologist_id) {
                Alert::error('خطا', 'مشاور نمی‌تواند با جراح یا متخصص بیهوشی یک نفر باشند');
                return redirect()->back()->withInput();
            }
        }

        // اعتبارسنجی داده‌های ورودی
        $request->validate([
            'patient_name' => 'required|string',
            'patient_national_code' => 'required|string|max:20',
            'operations' => 'required|array',
            'operations.*' => 'exists:operations,id',
            'basic_insurance_id' => 'nullable|exists:insurances,id',
            'supp_insurance_id' => 'nullable|exists:insurances,id',
            'document_number' => 'required|integer|unique:surgeries,document_number,' . $id,
            'surgeried_at' => 'required|string', // تغییر به string
            'released_at' => 'required|string', // تغییر به string
            'description' => 'nullable|string',
            'surgeon_id' => 'required|exists:doctors,id',
            'anesthesiologist_id' => 'required|exists:doctors,id',
            'consultant_id' => 'nullable|exists:doctors,id'
        ]);

        // تبدیل تاریخ‌های شمسی به میلادی
        $surgeried_at = Jalalian::fromFormat('Y/m/d', $request->surgeried_at)->toCarbon();
        $released_at = Jalalian::fromFormat('Y/m/d', $request->released_at)->toCarbon();

        // یافتن عمل جراحی
        $surgery = Surgery::find($id);

        // بروزرسانی اطلاعات عمل جراحی
        $surgery->update([
            'patient_name' => $request->patient_name,
            'patient_national_code' => $request->patient_national_code,
            'basic_insurance_id' => $request->basic_insurance_id,
            'supp_insurance_id' => $request->supp_insurance_id,
            'document_number' => $request->document_number,
            'surgeried_at' => $surgeried_at, // ذخیره به صورت میلادی
            'released_at' => $released_at, // ذخیره به صورت میلادی
            'description' => $request->description,
        ]);
        // محاسبه مبلغ کل عملیات‌ها
        $total_amount = 0;

        // حذف عملیات‌های قبلی
        $surgery->operations()->detach();

    
        foreach ($request->operations as $operation_id) {
            $operation = Operation::find($operation_id);
            $total_amount += $operation->price;
            $surgery->operations()->attach($operation_id, ['amount' => $operation->price]);
        }


        $surgeon = Doctor::find($request->surgeon_id);
        $surgeon_role = $surgeon->roles->where('id', 1)->first();
        $surgeon_share = ($surgeon_role->quota / 100) * $total_amount;


        $anesthesiologist = Doctor::find($request->anesthesiologist_id);
        $anesthesiologist_role = $anesthesiologist->roles->where('id', 2)->first();
        $anesthesiologist_share = ($anesthesiologist_role->quota / 100) * $total_amount;

        $consultant_share = 0;
        if ($request->filled('consultant_id')) {
            $consultant = Doctor::find($request->consultant_id);
            $consultant_role = $consultant->roles->where('id', 3)->first();
            $consultant_share = ($consultant_role->quota / 100) * $total_amount;
        }


        $surgery->doctors()->detach();
        $surgery->doctors()->attach($request->surgeon_id, ['doctor_role_id' => 1, 'amount' => $surgeon_share]);
        $surgery->doctors()->attach($request->anesthesiologist_id, ['doctor_role_id' => 2, 'amount' => $anesthesiologist_share]);

        if ($request->filled('consultant_id')) {
            $surgery->doctors()->attach($request->consultant_id, ['doctor_role_id' => 3, 'amount' => $consultant_share]);
        }


        Alert::success('موفقیت', 'عمل جراحی با موفقیت بروزرسانی شد');
        return redirect()->route('Panel.SurgeryList');
    }

    public function destroy($id)
    {



        $surgery = Surgery::find($id);


        $surgery->doctors()->detach();


        $surgery->operations()->detach();


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
    public function details($id)
    {
        $user = Auth::user();
        $surgery = Surgery::find($id);
        return view('Panel.Surgery.details_surgery', compact('surgery', 'user'));
    }
}
