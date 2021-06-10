<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\AdminAuth\Models\AdminUser;
use App\Models\GadPlan;

class School extends Model
{
    protected $table = 'Schools';

    protected $fillable = [
        'name',
        'address',
        'admin_users_id',
        'status',
    
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
        return $this->hasMany(AdminUser::class);
    }

    public function gadplan(){ 
        return $this->hasMany(GadPlan::class);
    }
}
