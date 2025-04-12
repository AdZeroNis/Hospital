<?php

namespace App\Http\Controllers\Admin;

use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Surgery;
use App\Models\DoctorRole;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\SurgeryDoctor;  // Use SurgeryDoctor model

class InvoiceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $invoices = Invoice::all();
        return view('Admin.Invoice.invoice-list', compact('invoices', 'user'));
    }

    public function pay()
    {
        $user = Auth::user();
        $doctors = Doctor::orderBy('name')->get();
        return view('Admin.Invoice.invoice-pay', compact('user', 'doctors'));
    }

    public function searchPay(Request $request)
    {
        $user = Auth::user();
        $doctors = Doctor::orderBy('name')->get();

        if ($request->has('doctor_id') && $request->doctor_id) {
            $doctor = Doctor::with(['roles', 'speciality'])->findOrFail($request->doctor_id);

            // تبدیل تاریخ‌های شمسی به میلادی
            $startDate = $request->start_date ? Jalalian::fromFormat('Y/m/d', $request->start_date)->toCarbon() : null;
            $endDate = $request->end_date ? Jalalian::fromFormat('Y/m/d', $request->end_date)->toCarbon() : null;


            $surgeries = Surgery::with(['doctors', 'operations'])
            ->whereHas('doctors', function ($query) use ($request) {
                $query->where('doctors.id', $request->doctor_id)
                    ->whereNull('surgery_doctor.invoice_id');
            })
            ->when($startDate, function ($query) use ($startDate) {
                $query->where('surgeried_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->where('surgeried_at', '<=', $endDate);
            })
            ->get()
            ->map(function ($surgery) use ($doctor) {
                $doctorSurgery = $surgery->doctors->where('id', $doctor->id)->first();

                $roleName = 'تعیین نشده';
                $amount = 0;

                if ($doctorSurgery) {
                    $amount = $doctorSurgery->pivot->amount ?? 0;

                    if ($doctorSurgery->pivot->doctor_role_id) {
                        $role =DoctorRole::find($doctorSurgery->pivot->doctor_role_id);
                        if ($role) {
                            $roleName = $role->title;
                        }
                    }
                }

                return [
                    'id' => $surgery->id,
                    'patient_name' => $surgery->patient_name,
                    'operations' => $surgery->operations,
                    'role_name' => $roleName,
                    'amount' => $amount,
                    'surgeried_at' => $surgery->surgeried_at
                ];
            });


            $showSurgeryList = $doctor && $surgeries->isNotEmpty();
            $totalAmount = $surgeries->sum('amount');

            return view('Admin.Invoice.invoice-pay', compact('doctor', 'user', 'surgeries', 'doctors', 'showSurgeryList', 'totalAmount'));
        }

        return view('Admin.Invoice.invoice-pay', compact('user', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'surgery_ids' => 'required|array|min:1',
            'surgery_ids.*' => 'exists:surgeries,id',
            'total_amount' => 'required|numeric|min:0'
        ]);

        if (!$request->has('surgery_ids') || empty($request->surgery_ids)) {
            Alert::error('خطا', 'لطفا حداقل یک عمل را انتخاب کنید');
            return redirect()->back();
        }

        // فقط رکوردهای مربوط به پزشک مورد نظر
        $surgeryDoctors = SurgeryDoctor::with(['surgery'])
            ->where('doctor_id', $request->doctor_id)
            ->whereIn('surgery_id', $request->surgery_ids)
            ->get();

        if ($surgeryDoctors->isEmpty()) {
            Alert::error('خطا', 'عملیات انتخاب شده یافت نشد');
            return redirect()->back();
        }

        $invoice = Invoice::create([
            'doctor_id' => $request->doctor_id,
            'amount' => $request->total_amount,
            'status' => 0,
        ]);

        // فقط برای رکوردهای این پزشک invoice_id را تنظیم میکند
        foreach ($surgeryDoctors as $surgeryDoctor) {
            $surgeryDoctor->update([
                'invoice_id' => $invoice->id
            ]);
        }

        Alert::success('موفقیت', 'صورتحساب با موفقیت ایجاد شد');
        return redirect()->route('Panel.InvoiceList');
    }

    public function invoiceList()
    {
        $user = Auth::user();
        $invoices = Invoice::with(['doctor', 'payments'])
        ->latest()
        ->get();


        return view('Admin.Invoice.invoice-list', compact('invoices', 'user'));
    }
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);


        $invoice->surgeryDoctors()->update(['invoice_id' => null]);


        $invoice->payments()->delete();


        $invoice->delete();

        Alert::success('موفقیت', 'صورتحساب و پرداخت‌های مرتبط با موفقیت حذف شدند');
        return redirect()->route('Panel.InvoiceList');
    }
    public function print($id)
    {
        $invoice = Invoice::with([
            'doctor',
            'surgeryDoctors.surgery.operations',
            'payments'
        ])->findOrFail($id);

        // محاسبه مبالغ
        $totalAmount = $invoice->amount;
        $paidAmount = $invoice->payments->sum('amount');
        $remainingAmount = $totalAmount - $paidAmount;


        $surgeryDetails = $invoice->surgeryDoctors
            ->where('doctor_id', $invoice->doctor_id)
            ->map(function($surgeryDoctor) {
                return [
                    'patient_name' => $surgeryDoctor->surgery->patient_name,
                    'operations' => $surgeryDoctor->surgery->operations->pluck('name')->implode('، '),
                    'amount' => $surgeryDoctor->amount,
                    'surgeried_at' => Jalalian::fromDateTime($surgeryDoctor->surgery->surgeried_at)->format('Y/m/d'),
                    'discharged_at' => Jalalian::fromDateTime($surgeryDoctor->surgery->discharged_at ?? $surgeryDoctor->surgery->surgeried_at)->format('Y/m/d')
                ];
            });

        return view('Admin.Invoice.invoice', compact(
            'invoice',
            'surgeryDetails',
            'totalAmount',
            'paidAmount',
            'remainingAmount'
        ));
    }
    public function filters(Request $request)
    {
        $user = Auth::user();
        $query = Invoice::query()->with(['doctor', 'payments']);



        if ($request->has('search') && $request->search != '') {
            $query->whereHas('doctor', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });

        }


        if ($request->has('status') && $request->status !== '') {
            if ($request->status == 'paid') {
                $query->where('status', 1);
            } elseif ($request->status == 'pending') {
                $query->where('status', 0);
            }
        }


        $query->orderBy('created_at', 'desc');

        $invoices = $query->paginate(10);

        return view('Admin.Invoice.invoice-list', [
            'invoices' => $invoices,
            'search' => $request->search,
            'status' => $request->status,
            'user' => $user,
        ]);
    }

}



