<?php

namespace App\Http\Resources;
use Morilog\Jalali\Jalalian;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'doctor_id' => $this->doctor_id,
            'amount' => $this->amount,

            'status' => $this->status,
            'created_at' => Jalalian::fromDateTime($this->created_at)->format('Y/m/d H:i'),
            'updated_at' => Jalalian::fromDateTime($this->updated_at)->format('Y/m/d H:i'),
        ];
    }
}
