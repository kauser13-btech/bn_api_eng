<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
                    'n_head' => 'required',
                    'main_image' => 'mimes:jpg,bmp,png,gif|max:1500',
                ];
                break;
            case 'PUT':
            case 'PATCH':
                return [
                    'n_head' => 'required',
                    'main_image' => 'mimes:jpg,bmp,png,gif|max:1500',
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
            'main_image.max' => 'The main image size must be less then 1.5 MB'
        ];
    }
}
