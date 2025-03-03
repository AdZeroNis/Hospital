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
use Carbon\Carbon;


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
        return view('Panel.Surgery.createSurgery', compact('user', 'insurances', 'doctors', 'operations'));
    }

    public function store(Request $request)
    {
        try {
            // تبدیل تاریخ‌های شمسی به میلادی
            $request->merge([
                'surgeried_at' => Carbon::parse($request->surgeried_at)->toDateTimeString(),
                'released_at' => Carbon::parse($request->released_at)->toDateTimeString(),
            ]);

            // Validate the request
            $request->validate([
                'patient_name' => 'required|string|max:100',
                'patient_national_code' => 'required|string|max:20',
                'operation_id' => 'required|exists:operations,id',
                'basic_insurance_id' => 'nullable|exists:insurances,id',
                'supp_insurance_id' => 'nullable|exists:insurances,id',
                'document_number' => 'required|integer|unique:surgeries',
                'surgeried_at' => 'required|date',
                'released_at' => 'required|date|after_or_equal:surgeried_at',
                'description' => 'nullable|string',
                'amount' => 'required|numeric|min:0',
                'surgeon_id' => 'required|exists:doctors,id',
                'anesthesiologist_id' => 'required|exists:doctors,id|different:surgeon_id',
                'consultant_id' => 'nullable|exists:doctors,id|different:surgeon_id|different:anesthesiologist_id'
            ]);

            DB::beginTransaction();

            // Create surgery record
            $surgery = Surgery::create([
                'patient_name' => $request->patient_name,
                'patient_national_code' => $request->patient_national_code,
                'basic_insurance_id' => $request->basic_insurance_id,
                'supp_insurance_id' => $request->supp_insurance_id,
                'document_number' => $request->document_number,
                'surgeried_at' => $request->surgeried_at,
                'released_at' => $request->released_at,
                'description' => $request->description
            ]);

            // Get doctor roles with their shares
            $doctorRoles = DoctorRole::whereIn('id', [1, 2, 3])->pluck('quota', 'id');

            // Calculate shares based on surgery cost
            $surgeonShare = $doctorRoles[1]; // سهم جراح
            $anesthesiologistShare = $doctorRoles[2]; // سهم متخصص بیهوشی
            $consultantShare = $doctorRoles[3] ?? 0; // سهم مشاور

            // اگر مشاور نداشته باشیم، سهم مشاور به جراح اضافه می‌شود
            if (!$request->consultant_id) {
                $surgeonShare += $consultantShare;
                $consultantShare = 0;
            }

            // محاسبه مبلغ هر پزشک
            $totalCost = $request->amount;
            $doctors = [
                1 => [
                    'id' => $request->surgeon_id,
                    'amount' => ($surgeonShare / 100) * $totalCost
                ],
                2 => [
                    'id' => $request->anesthesiologist_id,
                    'amount' => ($anesthesiologistShare / 100) * $totalCost
                ]
            ];

            if ($request->consultant_id) {
                $doctors[3] = [
                    'id' => $request->consultant_id,
                    'amount' => ($consultantShare / 100) * $totalCost
                ];
            }

            $now = now();

            // اتصال پزشکان به جراحی با مقادیر محاسبه شده
            foreach ($doctors as $roleId => $doctor) {
                DB::table('surgery_doctor')->insert([
                    'surgery_id' => $surgery->id,
                    'doctor_id' => $doctor['id'],
                    'doctor_role_id' => $roleId,
                    'amount' => $doctor['amount'],
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
            }

            // Get operation cost
            $operation = Operation::find($request->operation_id);
            $operationAmount = $operation ? $operation->cost : 0;

            // Create surgery_operation record with amount
            DB::table('surgery_operation')->insert([
                'surgery_id' => $surgery->id,
                'operation_id' => $request->operation_id,
                'amount' => $operationAmount,
                'created_at' => $now,
                'updated_at' => $now
            ]);

            DB::commit();
            Alert::success('موفقیت', 'عمل جراحی با موفقیت ثبت شد');
            return redirect()->route('Panel.SurgeryList');

        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('خطا', 'خطا در ثبت عمل جراحی');
            return back()->withInput();
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        $surgery = Surgery::find($id);
        $insurances = Insurance::all();
        $doctors = Doctor::all();
        $operations = Operation::all();
        return view('Panel.Surgery.editSurgery', compact('surgery', 'user', 'insurances', 'doctors', 'operations'));
    }

    public function update(Request $request, $id)
    {
        try {
            // تبدیل تاریخ‌های شمسی به میلادی
            $request->merge([
                'surgeried_at' => Carbon::parse($request->surgeried_at)->toDateTimeString(),
                'released_at' => Carbon::parse($request->released_at)->toDateTimeString(),
            ]);

            // Validate the request
            $request->validate([
                'patient_name' => 'required|string|max:100',
                'patient_national_code' => 'required|string|max:20',
                'operation_id' => 'required|exists:operations,id',
                'basic_insurance_id' => 'nullable|exists:insurances,id',
                'supp_insurance_id' => 'nullable|exists:insurances,id',
                'document_number' => 'required|integer|unique:surgeries,document_number,' . $id,
                'surgeried_at' => 'required|date',
                'released_at' => 'required|date|after_or_equal:surgeried_at',
                'description' => 'nullable|string',
                'amount' => 'required|numeric|min:0',
                'surgeon_id' => 'required|exists:doctors,id',
                'anesthesiologist_id' => 'required|exists:doctors,id|different:surgeon_id',
                'consultant_id' => 'nullable|exists:doctors,id|different:surgeon_id|different:anesthesiologist_id'
            ]);

            DB::beginTransaction();

            // Update surgery record
            $surgery = Surgery::find($id);
            $surgery->update([
                'patient_name' => $request->patient_name,
                'patient_national_code' => $request->patient_national_code,
                'basic_insurance_id' => $request->basic_insurance_id,
                'supp_insurance_id' => $request->supp_insurance_id,
                'document_number' => $request->document_number,
                'surgeried_at' => $request->surgeried_at,
                'released_at' => $request->released_at,
                'description' => $request->description
            ]);

            // Get doctor roles with their shares
            $doctorRoles = DoctorRole::whereIn('id', [1, 2, 3])->pluck('quota', 'id');

            // Calculate shares based on surgery cost
            $surgeonShare = $doctorRoles[1]; // سهم جراح
            $anesthesiologistShare = $doctorRoles[2]; // سهم متخصص بیهوشی
            $consultantShare = $doctorRoles[3] ?? 0; // سهم مشاور

            // اگر مشاور نداشته باشیم، سهم مشاور به جراح اضافه می‌شود
            if (!$request->consultant_id) {
                $surgeonShare += $consultantShare;
                $consultantShare = 0;
            }

            // محاسبه مبلغ هر پزشک
            $totalCost = $request->amount;
            $doctors = [
                1 => [
                    'id' => $request->surgeon_id,
                    'amount' => ($surgeonShare / 100) * $totalCost
                ],
                2 => [
                    'id' => $request->anesthesiologist_id,
                    'amount' => ($anesthesiologistShare / 100) * $totalCost
                ]
            ];

            if ($request->consultant_id) {
                $doctors[3] = [
                    'id' => $request->consultant_id,
                    'amount' => ($consultantShare / 100) * $totalCost
                ];
            }

            // Delete existing doctor relationships
            DB::table('surgery_doctor')->where('surgery_id', $id)->delete();

            $now = now();

            // اتصال پزشکان به جراحی با مقادیر محاسبه شده
            foreach ($doctors as $roleId => $doctor) {
                DB::table('surgery_doctor')->insert([
                    'surgery_id' => $surgery->id,
                    'doctor_id' => $doctor['id'],
                    'doctor_role_id' => $roleId,
                    'amount' => $doctor['amount'],
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
            }

            // Get operation cost
            $operation = Operation::find($request->operation_id);
            $operationAmount = $operation ? $operation->cost : 0;

            // Delete existing operation relationship
            DB::table('surgery_operation')->where('surgery_id', $id)->delete();

            // Create new surgery_operation record with amount
            DB::table('surgery_operation')->insert([
                'surgery_id' => $surgery->id,
                'operation_id' => $request->operation_id,
                'amount' => $operationAmount,
                'created_at' => $now,
                'updated_at' => $now
            ]);

            DB::commit();
            Alert::success('موفقیت', 'عمل جراحی با موفقیت بروزرسانی شد');
            return redirect()->route('Panel.SurgeryList');

        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('خطا', 'خطا در بروزرسانی عمل جراحی');
            return back()->withInput();
        }
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
