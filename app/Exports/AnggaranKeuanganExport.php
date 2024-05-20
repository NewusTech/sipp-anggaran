<?php

namespace App\Exports;

use App\Models\Anggaran;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AnggaranKeuanganExport implements FromCollection, WithHeadings
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Anggaran::select('tanggal', 'daya_serap_kontrak', 'sisa_kontrak', 'sisa_anggaran')->get();
    }

    public function headings(): array
    {
        return ['Tanggal', 'Daya Serap Kontrak', 'Sisa Kontrak', 'Sisa Anggaran'];
    }
}
