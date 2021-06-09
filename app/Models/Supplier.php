<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Brackets\AdminAuth\Models\AdminUser;

class Supplier extends Model
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
        return url('/admin/suppliers/'.$this->getKey());
    }

    /* ******************** RELATIONSHIP ************************ */

    public function user(){ 
        return $this->belongsTo(AdminUser::class, 'added_by');
    }
}
