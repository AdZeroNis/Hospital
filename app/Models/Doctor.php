<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hekmatinasser\Verta\Verta;
use Laravel\Sanctum\HasApiTokens;

class Doctor extends Model
{
    use HasApiTokens;
    protected $fillable = [
        'name', 'speciality_id', 'national_code', 'medical_number', 'mobile', 'password', 'status'
    ];

    protected $hidden = ['password'];

    protected static function booted(): void
    {
        static::deleting(function (Doctor $doctor) {
            if ($doctor->isDeletable()) {
                abort(403, 'fORBIDDEN');
                //abort_if
            }
        });
    }

    public function isDeletable()
    {
        return $this->surgeries()->exists();
    }

    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }

    public function roles()
    {
        return $this->belongsToMany(DoctorRole::class, 'role_doctor_doctor', 'doctor_id', 'doctor_role_id');
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function surgeries()
    {
        return $this->belongsToMany(Surgery::class, 'surgery_doctor', 'doctor_id', 'surgery_id')
                    ->withPivot('doctor_role_id', 'invoice_id', 'amount');
    }

    public function surgeryDoctors()
    {
        return $this->hasMany(SurgeryDoctor::class);
    }
    public function getCreateAtShamsi()
    {
        return Verta::instance($this->created_at)->format('Y/n/j H:i');;
    }
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Invoice::class, 'doctor_id', 'invoice_id');
    }

}
