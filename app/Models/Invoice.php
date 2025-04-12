<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hekmatinasser\Verta\Verta;

class Invoice extends Model
{
    protected $fillable = ['doctor_id', 'amount', 'description', 'status'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function surgeryDoctors()
    {
        return $this->hasMany(SurgeryDoctor::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function getCreatedAtShamsi()
    {
        return new Verta($this->created_at);
    }
    public function getCreateAtShamsi()
    {
        return Verta::instance($this->created_at)->format('Y/n/j H:i');;
    }
}
