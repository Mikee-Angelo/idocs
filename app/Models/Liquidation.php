<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LiquidationItem;
use Brackets\AdminAuth\Models\AdminUser;

class Liquidation extends Model
{
    protected $fillable = [
        'purpose',
        'admin_users_id',
        'status',
        'isSent',
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/liquidations/'.$this->getKey());
    }
    
    public function liquidation_items(){ 
        return $this->hasMany(LiquidationItem::class, 'liquidation_id');
    }

    public function admin_user(){ 
        return $this->belongsTo(AdminUser::class, 'admin_users_id'); 
    }

}
