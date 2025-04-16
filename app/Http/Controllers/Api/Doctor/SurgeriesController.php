<?php

namespace App\Http\Controllers\Api\Doctor;

use Illuminate\Http\Request;
use App\Models\SurgeryDoctor;
use App\Http\Controllers\Controller;
use App\Models\Surgery;

class SurgeriesController extends Controller
{
    public function getSurgeries(Request $request)
    {
      $doctor=$request->user();
      $surgeries = SurgeryDoctor::with(['doctor','surgery','doctorRole'])
          ->where('doctor_id', $doctor->id)
          ->get();

      if($surgeries->isEmpty())
      {
        return response()->error(
            'هیچ عمل جراحی برای این پزشک یافت شد',
            404
        );
      }

      return response()->success(
        [
            'surgeries' => $surgeries,
        ],
        ' عمل های جراحی بازیابی شدند'
    );
    }
    public function detailsSurgery($id, Request $request)
{
    $doctor = $request->user();

    $surgery = Surgery::with(['doctors.roles', 'doctors.invoices.payments'])
        ->findOrFail($id);


       $isDoctorInSurgery = $surgery->doctors->contains(function ($doc) use ($doctor) {
        return $doc->id === $doctor->id;
    });

    if (!$isDoctorInSurgery) {
        return response()->error(
            'شما در این عمل جراحی حضور ندارید',
            403
        );
    }
    $doctorsInfo = $surgery->doctors->map(function ($doc) {
        $role = $doc->roles->where('id', $doc->pivot->doctor_role_id)->first();
        $roleName = $role ? $role->title : 'بدون نقش';

        $doctorShare = $doc->pivot->amount ?? 0;

        $totalPayments = $doc->invoices->flatMap->payments->sum('amount') ?? 0;

        $fullyPaid = $totalPayments >= $doctorShare;

        return [
            'name' => $doc->name,
            'role' => $roleName,
            'share' => $doctorShare,
            'paid_amount' => $totalPayments,
            'fully_paid' => $fullyPaid,
            'has_invoices' => $doc->invoices->isNotEmpty(),
        ];
    });

    return response()->success(
        [
            'surgery' => [
                'id' => $surgery->id,
                'title' => $surgery->title,
                'date' => $surgery->created_at,
                'doctors' => $doctorsInfo,
            ]
        ],
        'جزییات عمل جراحی با موفقیت دریافت شد.'
    );

}
}
