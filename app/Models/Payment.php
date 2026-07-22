<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['participant_id', 'amount', 'status', 'payment_method', 'payment_date'];

    protected function casts(): array
    {
        return [
            'payment_date' => 'datetime',
        ];
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
