<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use SoftDeletes;
    protected $fillable = ['trx_id', 'name', 'email', 'phone', 'instansi', 'event_id', 'status', 'checked_in', 'checkin_time'];

    protected function casts(): array
    {
        return [
            'checked_in' => 'boolean',
            'checkin_time' => 'datetime',
        ];
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
