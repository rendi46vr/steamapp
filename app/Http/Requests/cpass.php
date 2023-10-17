<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class cpass extends FormRequest
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
            'passwordlama' => 'required',
            'passbaru' => 'required|min:8|same:cpassbaru',
            'cpassbaru' => 'required',
        ];

        return $data + $rules;
    }

    public function messages()
    {
        return [
            'passwordlama.required' => 'Password Lama Wajib Diisi',
            'passbaru.required' => 'Password Baru Wajib Diisi',
            'passbaru.min' => 'Password Baru minimal 8 karakter',
            'passbaru.same' => 'Password Baru harus sama dengan Konfirmasi Password Baru',
            'cpassbaru.required' => 'Konfirmasi Password Baru Wajib Diisi',
        ];
    }

    public function attributes()
    {
        return [
            'passwordlama' => 'Password Lama',
            'passbaru' => 'Password Baru',
            'cpassbaru' => 'Konfirmasi Password Baru',
        ];
    }
}
