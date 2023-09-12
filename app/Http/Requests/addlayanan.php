<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addlayanan extends FormRequest
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
            'deskripsi' => 'required',
            'harga' => 'required:number:max:20',
            'qtyoption' => 'required:number:max:99',
        ];
        return $data;
    }
    public function messages()
    {
        return [
            'layanan.required' => 'Layanan Wajib Disi',
            'deskripsi.required' => 'Deskripsi Wajib Disi',
            'harga.required' => 'Harga Wajib Disi',
            'qty.required' => 'Qty Wajib Disi',

            // 'tgl.required' => "Hanya weekend dan libur nasional",
            // 'tgl.max' => "Hanya weekend dan libur nasional",
        ];
    }

    public function attributes()
    {
        return [
            'layanan' => 'Layanan',
            'deskripsi' => 'Deskripsi',
            'harga' => 'Harga',
            'qty' => 'Qty',
        ];
    }
}
