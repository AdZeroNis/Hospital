<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name', 'speciality_id', 'national_code', 'medical_number', 'mobile', 'password', 'status'
    ];

    protected $hidden = ['password'];

    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }

    public function roles()
    {
        return $this->belongsToMany(DoctorRole::class, 'role_doctor_doctor', 'doctor_id', 'doctor_role_id');
    }

    public function surgeries()
    {
        return $this->belongsToMany(Surgery::class, 'surgery_doctor', 'doctor_id', 'surgery_id')
                    ->withPivot('doctor_role_id', 'invoice_id', 'amount');
    }

   
}
