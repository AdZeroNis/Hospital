<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hekmatinasser\Verta\Verta;
class Operation extends Model
{
    protected $fillable = ['name', 'price', 'status'];

    protected static function booted(): void
    {
        static::deleting(function (Operation $operation) {
            if ($operation->isDeletable()) {
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
        return $this->belongsToMany(Surgery::class, 'surgery_operation', 'operation_id', 'surgery_id')
                    ->withPivot('amount');
    }
    public function getCreateAtShamsi()
    {
        return new Verta($this->created_at);
    }
}
