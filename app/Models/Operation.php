<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $fillable = ['name', 'price', 'status'];

    public function surgeries()
    {
        return $this->belongsToMany(Surgery::class, 'surgery_operation', 'operation_id', 'surgery_id')
                    ->withPivot('amount');
    }
}
