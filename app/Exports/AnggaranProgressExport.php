<?php

namespace App\Exports;

use App\Models\Anggaran;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AnggaranProgressExport implements FromCollection, WithHeadings
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Anggaran::select('tanggal', 'keterangan', 'progress')->get();
    }

    public function headings(): array
    {
        return ['Tanggal', 'Keterangan', 'Progress (%)'];
    }
}
