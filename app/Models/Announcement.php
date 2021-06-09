<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'event_type_id',
        'header_img',
        'title',
        'description',
        'url',
        'starts_at',
        'ends_at',
        'created_by',
    
    ];
    
    
    protected $dates = [
        'starts_at',
        'ends_at',
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/announcements/'.$this->getKey());
    }
}
