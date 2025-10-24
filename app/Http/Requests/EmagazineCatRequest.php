<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class EmagazineCatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::user()->role == 'subscriber') {
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required',
                    'slug' => 'required|unique:emagazinecats,slug',
                ];
                break;
            case 'PUT':
            case 'PATCH':
                return [
                    'name' => 'required|unique:emagazinecats,name,' . $this->request->get('id') . ',id',
                    'slug' => 'required|unique:emagazinecats,slug,' . $this->request->get('id') . ',id',
                ];
                break;
            case 'DELETE':
                return [];
                break;
            default:
                break;
        }
    }
}
