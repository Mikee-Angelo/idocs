<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SourceOfBudget extends Model
{
    protected $table = 'source_of_budget';

    protected $fillable = [
        'name',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/source-of-budgets/'.$this->getKey());
    }
}
