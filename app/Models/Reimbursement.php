<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\AdminAuth\Models\AdminUser;
class Reimbursement extends Model
{
    protected $fillable = [
        'letter_body',
        'admin_user_id',
        'status',
        'rmb_no',
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/reimbursements/'.$this->getKey());
    }

    public function admin_user(){ 
        return $this->belongsTo(AdminUser::class, 'admin_user_id'); 
    }
}
