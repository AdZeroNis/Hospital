<?php

namespace App\Http\Controllers\Admin;

use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{
    public function index($id)
    {
        $user = Auth::user();

        // Get the invoice by its ID
        $invoice = Invoice::find($id);

        // Fetch all invoices for the user (You can customize this query as needed)
        $invoices = Invoice::where('doctor_id', $user->id)->get();

        // Default values
        $paidAmount = 0;
        $totalAmount = 0;
        $remainingAmount = 0;

        if ($invoice) {
            $totalAmount = $invoice->amount;
            $paidAmount = Payment::where('invoice_id', $invoice->id)->sum('amount');
            $remainingAmount = $totalAmount - $paidAmount;

            // Fetch payments for this specific invoice
            $payments = Payment::where('invoice_id', $invoice->id)->get();
        } else {
            Alert::error('خطا', 'صورتحساب یافت نشد.');
            return redirect()->back();
        }

        return view('Admin.payment.payment', [
            'user' => $user,
            'invoice' => $invoice,
            'invoices' => $invoices,  // Pass the list of invoices
            'payments' => $payments,  // Pass the payments for this invoice
            'paidAmount' => $paidAmount,
            'totalAmount' => $totalAmount,
            'remainingAmount' => $remainingAmount
        ]);
    }


    public function deleteInvoice($id)
    {
        $payment = Payment::findOrFail($id);
        $invoice = $payment->invoice;

        // حذف پرداخت
        $payment->delete();

        $this->checkfFullyPaid($invoice);

        Alert::success('موفقیت', 'پرداخت با موفقیت حذف شد.');
        return redirect()->route('Panel.StorePayment', ['id' => $invoice->id]);
    }

    public function storePayment(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric',
            'receipt_number' => 'required',
            'pay_type' => 'required|in:cash,cheque',
            'description' => 'nullable|string',
            'receipt' => 'required_if:pay_type,cheque|image|mimes:jpeg,png,jpg,gif|max:2048',
            'due_date' => 'required_if:pay_type,cheque|date_format:Y/m/d',
        ], [
            'receipt.required_if' => 'تصویر چک برای پرداخت چکی الزامی است.',
            'due_date.required_if' => 'تاریخ سررسید برای پرداخت چکی الزامی است.'
        ]);

        $invoice = Invoice::findOrFail($request->invoice_id);

        $paidAmount = Payment::where('invoice_id', $invoice->id)->sum('amount');
        $remainingAmount = $invoice->amount - $paidAmount;

        if ($request->amount > $remainingAmount) {
            Alert::error('خطا', 'مبلغ پرداختی بیشتر از مبلغ باقیمانده صورتحساب است باقیمانده: ' . number_format($remainingAmount) . ' ریال');
            return redirect()->back();
        }

        $imageName = null;
        if ($request->pay_type === 'cheque') {
            if (!$request->hasFile('receipt')) {
                Alert::error('خطا', 'تصویر چک برای پرداخت چکی الزامی است.');
                return redirect()->back();
            }

            $imageName = time() . '.' . $request->file('receipt')->extension();
            $request->file('receipt')->move(public_path('Adminasset/image/receipt_image'), $imageName);
        }

        Payment::create([
            'invoice_id' => $request->invoice_id,
            'receipt_number' => $request->receipt_number,
            'amount' => $request->amount,
            'due_date' => $request->pay_type === 'cheque' ? Jalalian::fromFormat('Y/m/d', $request->due_date)->toCarbon() : null,
            'receipt' => $imageName,
            'description' => $request->description,
            'doctor_id' => $invoice->doctor_id,
            'pay_type' => $request->pay_type
        ]);

        $this->checkfFullyPaid($invoice);

        Alert::success('موفقیت', 'پرداخت ' . ($request->pay_type === 'cash' ? 'نقدی' : 'چکی') . ' با موفقیت ثبت شد.');
        return redirect()->route('Panel.InvoiceList', ['id' => $invoice->id]);
    }


    private function checkfFullyPaid($invoice)
    {
        $totalAmount = $invoice->amount;
        $paidAmount = Payment::where('invoice_id', $invoice->id)->sum('amount');

        if ($paidAmount >= $totalAmount && $invoice->status != 1) {
            // اگر مبلغ پرداخت‌شده کامل شد و هنوز وضعیت روی 1 نیست
            $invoice->status = 1;
            $invoice->save();
        } elseif ($paidAmount < $totalAmount && $invoice->status != 0) {
            // اگر مبلغ کمتر از فاکتور شد (مثلاً چون یکی حذف شده) و وضعیت باید 0 بشه
            $invoice->status = 0;
            $invoice->save();
        }
    }


    public function paymentReport($doctorId, $invoiceId)
    {
        $user = Auth::user();

        // دریافت دکتر با فاکتور و جراحی‌ها
        $doctor = Doctor::with(['payments.invoice.surgeryDoctors.surgery'])->findOrFail($doctorId);

        // دریافت فقط پرداخت‌هایی که مربوط به این فاکتور هستند
        $payments = $doctor->payments()
            ->where('invoice_id', $invoiceId)
            ->with(['invoice.surgeryDoctors.surgery'])
            ->orderBy('created_at', 'desc')
            ->get();

        // جمع کل پرداخت‌ها
        $totalPaid = $payments->sum('amount');

        // آماده‌سازی داده‌ها برای نمایش
        $paymentDetails = $payments->map(function ($payment) {
            $surgeryDoctor = $payment->invoice->surgeryDoctors->first();
            $surgery = $surgeryDoctor->surgery ?? null;

            return [
                'id' => $payment->id,
                'amount' => number_format($payment->amount) . ' تومان',
                'payment_date' => \Morilog\Jalali\Jalalian::fromDateTime($payment->created_at)->format('Y/m/d'),
                'operation_names' => $surgery ? $surgery->operations->pluck('name')->implode('، ') : 'نامشخص',
                'patient_name' => $surgery ? $surgery->patient_name : 'نامشخص',
                'receipt_number' => $payment->receipt ?? 'نامشخص',
            ];
        });

        return view('Admin.Payment.payment-report', compact('doctor', 'paymentDetails', 'totalPaid', 'user'));
    }
}
