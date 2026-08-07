<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;
    protected $fillable = ['slug', 'title', 'speaker', 'time_slot', 'image', 'date', 'location', 'desc', 'price', 'quota', 'status'];

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_CLOSED = 'closed';
    const STATUS_COMPLETED = 'completed';

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function getRupiahAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80';
        }

        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public function isRegistrationOpen(): bool
    {
        return $this->isPublished() && $this->date > now();
    }

    public function isSoldOut(): bool
    {
        return $this->participants()->where('status', 'lunas')->count() >= $this->quota;
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_PUBLISHED => 'Dibuka',
            self::STATUS_CLOSED => 'Ditutup',
            self::STATUS_COMPLETED => 'Selesai',
            default => 'Unknown',
        };
    }
}
