<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['invoice_id', 'amount', 'pay_type', 'due_date', 'receipt', 'description', 'status'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

}

