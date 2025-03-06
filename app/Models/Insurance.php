<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hekmatinasser\Verta\Verta;
class Insurance extends Model
{
    protected $fillable = ['name', 'type', 'discount', 'status'];
    protected static function booted(): void
    {
        static::deleting(function (Insurance $insurance) {
            if ($insurance->isDeletable()) {
                abort(403, 'fORBIDDEN');
                //abort_if
            }
        });
    }

    public function isDeletable()
    {
        return $this->surgeries()->exists();
    }

    public function surgeries()
    {
        return $this->hasMany(Surgery::class, 'basic_insurance_id')
                    ->orWhere('supp_insurance_id', $this->id);
    }
    public function getCreateAtShamsi()
    {
        return Verta::instance($this->created_at)->format('Y/n/j H:i');;
    }
}
