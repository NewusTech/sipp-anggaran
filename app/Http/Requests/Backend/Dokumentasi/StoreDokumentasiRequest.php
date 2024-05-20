<?php

namespace App\Http\Requests\Backend\Dokumentasi;

use Illuminate\Foundation\Http\FormRequest;

class StoreDokumentasiRequest extends FormRequest
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
            'name' => 'required',
            'detail_kegiatan_id' => 'required'
//            'file_name' => 'required|mimes:jpeg,jpg,png,pdf,xlsx,xls,docx,doc|max:2048'
        ];
    }
}
