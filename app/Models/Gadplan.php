<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gadplan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'implement_year', 
        'status',
    ];
}
