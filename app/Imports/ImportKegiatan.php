<?php

namespace App\Imports;

use App\Models\Bidang;
use App\Models\DetailKegiatan;
use App\Models\Kegiatan;
use App\Models\SubKegiatan;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportKegiatan implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $subId = SubKegiatan::where('title', $row['sub_kegiatan'])->first()->id;
            $kegiatanId = Kegiatan::where('title', $row['kegiatan'])->first()->id;
            $bidangId = Bidang::where('name', 'Bidang' . ' ' . $row['bidang'])->first()->id;
            // dd($row['pekerjaan'],$row['jenis_pengadaan']);
            // dd($subId, $kegiatanId, $bidangId);
            DetailKegiatan::create([
                'title' => $row['pekerjaan'],
                'no_detail_kegiatan' => 1,
                'no_kontrak' => '-',
                'jenis_pengadaan' => $row['jenis_pengadaan'],
                'nilai_kontrak' => 0,
                'pagu' => $row['pagu_anggaran'] ?? 0,
                'awal_kontrak' => Date::now(),
                'akhir_kontrak' => Date::now(),
                'sub_kegiatan_id' => $subId,
                'metode_pemilihan' => $row['metode_pemilihan'],
                'kegiatan_id' => $kegiatanId,
            ]);
        }
    }
}
