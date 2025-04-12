<?php

namespace App\Http\Controllers\Panel;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Insurance;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PanelController extends Controller
{
    public function Panel()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route("FormLogin")->with('error', 'User not found');
        }

        $doctorCount = Doctor::count();
        $insuranceCount = Insurance::count();

        // پرداخت‌های تسویه‌نشده
        $unpaidPayments = Invoice::with(['doctor'])
                                ->where('status', 0)
                                ->latest()
                                ->get();

        // چک‌هایی که سررسیدشان تا ۳ روز آینده است
        $nearDueChequePayments = Payment::with(['invoice.doctor'])
            ->where('pay_type', 'cheque')
            ->whereDate('due_date', '<=', Carbon::now()->addDays(3))
            ->whereDate('due_date', '>=', Carbon::now())
            ->get();

        return view('Panel.Main.main-part', compact(
            'user',
            'doctorCount',
            'insuranceCount',
            'unpaidPayments',
            'nearDueChequePayments'
        ));
    }

}
