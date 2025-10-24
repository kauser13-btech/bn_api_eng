<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Auth;

class PaperRequest extends FormRequest
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
                    'page' => 'required',
                    'photo' => 'required|mimes:jpg,png,gif',
                ];
                break;
            case 'PUT':
            case 'PATCH':
                return [];
                break;
            case 'DELETE':
                return [];
                break;
            default:break;
        }
        
    }
}
