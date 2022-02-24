<?php

namespace App\Http\Requests\Admin\GadPlanList;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreGadPlanList extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // return Gate::allows('admin.gad-plan-list.create');
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'gad_issue_mandate' => ['required', 'string'],
            'cause_of_issue' => ['required', 'string'],
            'gad_statement_objective' => ['required', 'string'],
            'relevant_agencies' => ['required', 'numeric'],
            'gad_activity' => ['required', 'string'],
            'indicator_target' => ['required', 'string'],
            'budget_requirement' => ['required', 'numeric'],
            'responsible_unit' => ['required', 'numeric'],
            
        ];
    }

    /**
    * Modify input data
    *
    * @return array
    */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
