<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Announcement;

class EventType extends Model
{
    protected $fillable = [
        'name',
        'admin_user_id',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/event-types/'.$this->getKey());
    }

    /********************** RELATIONSHIPS *************************/

    public function announcement(){ 
        return $this->hasMany(Announcement::class);
    }
}
