<?php

namespace App\Http\Requests\Backend\Anggaran;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnggaranRequest extends FormRequest
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
            'detail_kegiatan_id' => 'required',
            'daya_serap' => 'required',
            'tanggal' => 'required'
        ];
    }
}
