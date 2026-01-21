<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = [
        'title',
        'slug',
        'description',
        'event_date',
        'location',
        'status', // published/unpublished for admin toggle
    ];

    // Cast event_date to Carbon instance automatically
    protected $casts = [
        'event_date' => 'datetime',
    ];

    /**
     * Boot method to automatically generate slug when creating an event
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title) . '-' . uniqid();
            }
        });
    }

    /**
     * Use slug for route model binding
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Short description helper
     */
    public function shortDescription($limit = 120)
    {
        return Str::limit(strip_tags($this->description), $limit);
    }

    /**
     * Check if event is upcoming
     */
    public function isUpcoming()
    {
        return $this->event_date && $this->event_date->isFuture();
    }

    /**
     * Check if event is published
     */
    public function isPublished()
    {
        return $this->status === 'published';
    }

    /**
     * Toggle event status (publish/unpublish)
     */
    public function toggleStatus()
    {
        $this->status = $this->status === 'published' ? 'draft' : 'published';
        $this->save();
    }
}
