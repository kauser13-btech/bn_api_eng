<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Auth;

class GalleryRequest extends FormRequest
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
                    'category' => 'required',
                    'cover_photo' => 'required|mimes:jpg,png,gif|max:2000',
                    'images.*' => 'nullable|mimes:jpg,png,gif|max:2000',
                ];
                break;
            case 'PUT':
            case 'PATCH':
                return [
                    'name' => 'required',
                    'category' => 'required',
                    'cover_photo' => 'mimes:jpg,png,gif|max:2000',
                    'images.*' => 'nullable|mimes:jpg,png,gif|max:2000',
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
            'cover_photo.max' => 'The main image size must be less then 2 MB',
            // 'images.*.max' => 'The main image size must be less then 1.5 MB'
        ];
    }
}
