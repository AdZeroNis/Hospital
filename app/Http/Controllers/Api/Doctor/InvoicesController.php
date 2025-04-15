<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;

class InvoicesController extends Controller
{
    public function invoices(Request $request)
{
    $doctor = $request->user();

    $invoices = Invoice::where('doctor_id', $doctor->id)->get();

    return response()->json([
        'status' => true,
        'invoices' => InvoiceResource::collection($invoices),
    ]);
}
}
