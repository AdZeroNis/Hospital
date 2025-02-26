<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surgery extends Model
{
    protected $fillable = [
        'patient_name', 'patient_national_code', 'basic_insurance_id', 'supp_insurance_id',
        'document_number', 'description', 'surgeried_at', 'released_at'
    ];

    public function basicInsurance()
    {
        return $this->belongsTo(Insurance::class, 'basic_insurance_id');
    }

    public function suppInsurance()
    {
        return $this->belongsTo(Insurance::class, 'supp_insurance_id');
    }

    public function operations()
    {
        return $this->belongsToMany(Operation::class, 'surgery_operation', 'surgery_id', 'operation_id')
                    ->withPivot('amount');
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'surgery_doctor', 'surgery_id', 'doctor_id')
                    ->withPivot('doctor_role_id', 'invoice_id', 'amount');
    }
}
