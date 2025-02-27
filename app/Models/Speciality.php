<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Speciality extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'status'];


    protected static function booted(): void
    {
        static::deleting(function (Speciality $speciality) {
            if ($speciality->isDeletable()) {
                abort(403, 'fORBIDDEN');
                //abort_if
            }
        });
    }

    public function isDeletable()
    {
        return $this->doctors()->exists();
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}
