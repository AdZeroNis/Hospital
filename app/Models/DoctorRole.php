<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorRole extends Model
{
    protected $fillable = ['title', 'required', 'quota', 'status'];

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'role_doctor_doctor', 'doctor_role_id', 'doctor_id');
    }
}
