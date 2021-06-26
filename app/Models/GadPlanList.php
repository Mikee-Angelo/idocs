<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RelevantAgency; 
use App\Models\SourceOfBudget; 
use App\Models\GadPlanList; 

class GadPlanList extends Model
{
    protected $fillable = [
        'gad_plans_id',
        'gad_issue_mandate',
        'cause_of_issue',
        'gad_statement_objective',
        'relevant_agencies',
        'gad_activity',
        'indicator_target',
        'budget_requirement',
        'budget_source',
        'responsible_unit',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/gad-plan-lists/'.$this->getKey());
    }

    
    /* ******************** RELATIONSHIP *********************** */

    public function relevant_agency(){ 
        return $this->belongsTo(RelevantAgency::class, 'relevant_agencies');
    }

    public function sourceofbudget(){ 
        return $this->belongsTo(SourceOfBudget::class , 'budget_source');
    }

    public function gad_plan(){ 
        return $this->belongsTo(GadPlan::class, 'gad_plans_id');
    }

    public function responsible_unit(){ 
        return $this->belongsTo(School::class, 'responsible_unit');
    }
}
