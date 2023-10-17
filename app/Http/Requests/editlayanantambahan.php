<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class editlayanantambahan extends FormRequest
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
            'layanan' => 'required|max:255',
            'harga' => 'required:number:max:20',
            'diskon' => 'numeric|lte:harga',

        ];
        return $data;
    }
    public function messages()
    {
        return [
            'layanan.required' => 'Layanan Wajib Disi',
            'harga.required' => 'Harga Wajib Disi',
            'diskon.lt' => 'Diskon Tidak boleh melebihi harga',


            // 'tgl.required' => "Hanya weekend dan libur nasional",
            // 'tgl.max' => "Hanya weekend dan libur nasional",
        ];
    }

    public function attributes()
    {
        return [
            'layanan' => 'Layanan',
            'harga' => 'Harga',
            'diskon' => 'Diskon',

        ];
    }
}
