<?php

namespace App\Http\Requests\Admin\GadPlanList;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateGadPlanList extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.gad-plan-list.edit', $this->gadPlanList);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'gad_plans_id' => ['sometimes', 'string'],
            'gad_issue_mandate' => ['sometimes', 'string'],
            'cause_of_issue' => ['sometimes', 'string'],
            'gad_statement_objective' => ['sometimes', 'string'],
            'relevant_agencies' => ['sometimes', 'string'],
            'gad_activity' => ['sometimes', 'string'],
            'indicator_target' => ['sometimes', 'string'],
            'budget_requirement' => ['sometimes', 'numeric'],
            'budget_source' => ['sometimes', 'string'],
            'responsible_unit' => ['sometimes', 'string'],
            
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
