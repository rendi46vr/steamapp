<?php

namespace App\Http\Requests\pembayaran;

use Illuminate\Foundation\Http\FormRequest;

class request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      if(auth()->user()->role != 'Patner'){
        return $data = [
            'jumlah' => 'numeric',
            'patner_id' => 'required|exists:patners,id',
            'nowa' => 'required|regex:/^[0-9]+$/|digits_between:10,15',
            'alamat' => 'max:255',
            'email' => 'email|max:255',];

      }
     return   $data = [
            'jumlah' => 'numeric',
            'nowa' => 'required|regex:/^[0-9]+$/|digits_between:10,15',
            'alamat' => 'max:255',
            'email' => 'email|max:255',
        ];
    }
    public function messages()
    {
        return [
            'nama_patner.required' => 'Nama Patner harus Diisi',
            'nowa.required' => 'Nomor Whatsapp harus Diisi',
            'email.required' => 'Quantity Harus diisi',
        ];
    }
    public function attributes()
    {
        return [
            'nama_patner' => 'Nama Patner',
            'nowa' => ' Nomor Whatsapp',
            'alamat' => 'Tanggal Akhir',
            'email' => 'email',
        ];
    }
}
