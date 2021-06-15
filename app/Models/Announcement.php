<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EventType; 

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
        'model_id'
    
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

    /********************** RELATIONSHIPS *************************/

    public function event_types(){ 
        return $this->belongsTo(EventType::class, 'event_type_id');
    }
}
