<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class adduser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($rules = [])
    {
        $data = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|max:20',
        ];

        return $data + $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama Wajib Diisi',
            'name.max' => 'Nama tidak boleh lebih dari :max karakter',
            'email.required' => 'Email Wajib Diisi',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email tidak boleh lebih dari :max karakter',
            'role.required' => 'Peran Wajib Diisi',
            'role.max' => 'Peran tidak boleh lebih dari :max karakter',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama',
            'email' => 'Email',
            'role' => 'Peran',
        ];
    }
}
