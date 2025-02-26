<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    protected $fillable = ['name', 'type', 'discount', 'status'];

    public function surgeries()
    {
        return $this->hasMany(Surgery::class, 'basic_insurance_id')
                    ->orWhere('supp_insurance_id', $this->id);
    }
}
