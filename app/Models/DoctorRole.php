<?php

namespace App\Models;

use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoctorRole extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'required', 'quota', 'status'];

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'role_doctor_doctor', 'doctor_role_id', 'doctor_id');
    }
    public function getCreatedAtShamsi()
    {
        return Verta::instance($this->created_at)->format('Y/n/j H:i'); // بدون ثانیه
    }
}
