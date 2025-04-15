<?php

namespace App\Http\Controllers;

use App\Models\Invoice;

abstract class Controller
{
    public function index()
    {
        $invoices = Invoice::all();

        return response()->json([
            'invoices' => $invoices
        ]);
    }
}
