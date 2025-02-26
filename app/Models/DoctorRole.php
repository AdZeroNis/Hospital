<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorRole extends Model
{
    protected $table = 'roles_doctor';

    protected $fillable = [
        'title', 'quota', 'status'
    ];
}
