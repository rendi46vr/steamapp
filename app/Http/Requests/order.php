<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\tgltiket;

class order extends FormRequest
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
    public  $checkDate;

    public function __construct()
    {
        $this->checkDate = tgltiket::where('status', 2)->pluck('tgl')->toArray();
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($rules = [])
    {
        $data = [
            'name' => 'required',
            'tgl' => '',
            'wa' => 'required:max:60',
            'email' => 'required|email:dns',
            "jenis_kendaraan" => "required",
            "plat" => "required"
        ];


        return $data;
    }
    public function messages()
    {
        return [
            'wa.required' => 'Whatsapp harus didisi',
            'name.required' => 'Nama wajib disii!',
            'email.required' => 'Email Harus Diisi',
            'email.email' => 'Email harus valid',
            "plat.required" => "Plat Harus diisi",
            "jenis_kendaraan.required" => "Jenis Kendaraan Harus diisi"

            // 'tgl.required' => "Hanya weekend dan libur nasional",
            // 'tgl.max' => "Hanya weekend dan libur nasional",
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama',
            'tgl' => 'Tanggal',
            'wa' => 'Nomor whatsapp',
            'email' => 'Email',
            "jenis_kendaraan" => "Jenis Kendaraan",
            "plat" => "Plat"
        ];
    }
}
