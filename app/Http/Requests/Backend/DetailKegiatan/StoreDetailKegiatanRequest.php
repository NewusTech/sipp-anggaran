<?php

namespace App\Http\Requests\Backend\DetailKegiatan;

use Illuminate\Foundation\Http\FormRequest;

class StoreDetailKegiatanRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'no_detail_kegiatan' => 'required',
            'no_kontrak' => 'required',
            'jenis_pengadaan' => 'required',
            'awal_kontrak' => 'required',
            'akhir_kontrak' => 'required',
            'target' => 'required',
            'alamat' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'kegiatan_id' => 'required',
            'penyedia_jasa_id'=> 'required'
        ];
    }
}
