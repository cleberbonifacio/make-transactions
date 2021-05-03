<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:150',
            'id_type' => 'required|integer',
            'document' => 'required',
            'email' => 'required|email',
            'password' => 'required|max:50'
        ];
    }


}
