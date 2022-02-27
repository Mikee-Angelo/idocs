<?php

namespace App\Http\Requests\GadplanList;

use Illuminate\Foundation\Http\FormRequest;

class StoreGadplanListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'gad_issue_mandate' => 'required|string',
            'cause_of_issue' => 'required|string',
            'gad_statement_objective' => 'required|string',
            'relevant_agencies' => 'required|string|exists:agencies,id',
            'gad_activity' => 'required|string',
            'indicator_target' => 'required|string',
            'budget_requirement' => 'required|string',
            'responsible_unit' => 'required|string|exists:campuses,id',
        ];
    }
}
