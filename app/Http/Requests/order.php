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
            'tgl' => '',
            'wa' => 'required|numeric',
            'email' => 'email:dns',
            "plat" => "required",
            'type' => 'required',
            'durasi' => 'required_if:type,1',
            "metpem" => "required"
        ];


        return $data;
    }
    public function messages()
    {
        return [
            'name.' => 'Nama wajib disii!',
            'email.required' => 'Email Harus Diisi',
            'email.email' => 'Email harus valid',
            'wa.required' => 'Nomor Wa harus Diisi',
            "plat.required" => "Plat Harus diisi",
            "metpem.required" => "Metode Pembayaran Harus dipilih"

            // 'tgl.required' => "Hanya weekend dan libur nasional",
            // 'tgl.max' => "Hanya weekend dan libur nasional",
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama',
            'tgl' => 'Tanggal',
            'wa' => 'Nomor Wa',
            'email' => 'Email',
            "jenis_kendaraan" => "Jenis Kendaraan",
            "plat" => "Plat"
        ];
    }
}
