<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\AdminAuth\Models\AdminUser;
use App\Models\GadPlan;

class School extends Model
{
    protected $table = 'schools';

    protected $fillable = [
        'name',
        'address',
        'admin_users_id',
        'status',
        'letter_header',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/schools/'.$this->getKey());
    }

    public function admin_user() {
        return $this->belongsTo(AdminUser::class, 'admin_users_id');
    }

    public function gadplan(){ 
        return $this->hasMany(GadPlan::class);
    }
}
