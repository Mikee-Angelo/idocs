<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\AdminAuth\Models\AdminUser;

class Unit extends Model
{
    protected $fillable = [
        'name',
        'added_by',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/units/'.$this->getKey());
    }

    public function user(){ 
        return $this->belongsTo(AdminUser::class, 'added_by');
    }
}
