<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
           'name'=>'required',
           'email'=>'required|email|unique:users,email',
           'password'=>'required|min:6|max:12',
           'password_confirmation'=>'required|same:password',
           'assignation_employee_id'=>'required|integer'
        ];
    }
}
