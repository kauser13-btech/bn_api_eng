<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->role == 'subscriber') {
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method()){
            case 'POST':
                return [
                    'name' => 'required',
                    'email' => 'required|email:rfc,dns|unique:users,email',
                    'password' => 'required',
                    'role' => 'required',
                    'type' => 'required',
                    'status' => 'required',
                ];
                break;
            case 'PUT':
            case 'PATCH':
                return [
                    'name' => 'required',
                    'email'   => 'required|email:rfc,dns|unique:users,email,'.$this->segment(3),
                    'role' => 'required',
                    'type' => 'required',
                    'status' => 'required',
                ];
                break;
            case 'DELETE':
                return [];
                break;
            default:break;
        }
        
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Display Name is required',
        ];
    }
}
