<?php

namespace App\Http\Requests\ManageUser;

use Illuminate\Foundation\Http\FormRequest;

class StoreManageUserRequest extends FormRequest
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
            'role' => 'required|exists:roles,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'campus' => 'required|exists:campuses,id', 
        ];
    }
}
