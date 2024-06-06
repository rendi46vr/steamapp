<?php

namespace App\Http\Requests\layanan\paket;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class editpaket extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($rules = [])
    {
        $data = [
            'nama_paket' => 'required|max:255',
            'layanan_id' => 'required',
            'durasi' => 'numeric|max:99',
            'harga' => 'numeric',
        ];
        return $data;
    }
    public function messages()
    {
        return [
            'layanan.required' => 'Layanan Wajib Disi',
            'deskripsi.required' => 'Deskripsi Wajib Disi',
            'harga.required' => 'Harga Wajib Disi',
            'diskon.lt' => 'Diskon harus dibawah harga',
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
            'diskon' => 'Diskon',
            'qty' => 'Qty',
        ];
    }
}
