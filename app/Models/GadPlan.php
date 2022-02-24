<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; 
use App\Models\School;
use App\Models\Proposal;
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

    public function admin_user(){ 
        return $this->belongsTo(AdminUser::class, 'model_id');
    }

    public function gad_plan_list(){ 
        return $this->hasMany(GadPlanList::class, 'id');
    }

    public function proposal(){ 
        return $this->hasMany(Proposal::class, 'id');
    }
  
}
