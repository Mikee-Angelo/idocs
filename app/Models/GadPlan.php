<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; 
use Brackets\AdminAuth\Models\AdminUser;

class GadPlan extends Model
{
    protected $fillable = [
        'role_id',
        'model_type',
        'model_id',
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
        return url('/admin/gad-plans/'.$this->getKey());
    }

    public function user(){ 
        return $this->belongsTo(AdminUser::class, 'model_id');
    }
}
