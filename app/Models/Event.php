<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    // NO SoftDeletes trait
    
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'full_description',
        'date',
        'time',
        'location',
        'venue',
        'organizer',
        'speakers',
        'agenda',
        'contact_email',
        'contact_phone',
        'website',
        'image',
        'views',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'speakers' => 'array',
        'agenda' => 'array',
        'views' => 'integer',
    ];
    
    // Add this method to fix route model binding
    public function getRouteKeyName()
    {
        return 'id';
    }
}