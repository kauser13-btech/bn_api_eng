<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
// use Illuminate\Validation\Rule;
class MenuRequest extends FormRequest
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
        if($this->request->get('slug')=='#'){
            return [
                'm_name' => 'required',
                'slug'          =>'required',
                'm_edition'     =>'required',
                'm_title'       =>'required',
                'm_keywords'    =>'required',
                'm_desc'        =>'required',
                'm_order'       =>'required',
            ];
        }
                
        switch($this->method()){
            case 'POST':
                return [
                    'm_name' => 'required',
                    'slug'          =>'required|unique:menus,slug',
                    'm_edition'     =>'required',
                    'm_title'       =>'required',
                    'm_keywords'    =>'required',
                    'm_desc'        =>'required',
                    'm_order'       =>'required',
                ];
                break;
            case 'PUT':
            case 'PATCH':
                return [
                    'm_name' => 'required',
                    'slug'   => 'required|unique:menus,slug,'.$this->segment(3).',m_id',
                    'm_edition'     =>'required',
                    'm_title'       =>'required',
                    'm_keywords'    =>'required',
                    'm_desc'        =>'required',
                    'm_order'       =>'required',
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
            'm_name.required' => 'Display Name is required',
            'm_name.unique' => 'Display name already exists',
            'slug.required' => 'Slug is required',
            'slug.unique' => 'Slug already exists',
        ];
    }
}
