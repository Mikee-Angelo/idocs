<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; 

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
        return $this->belongsTo(User::class, 'model_id');
    }
}
