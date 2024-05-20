<style>
	.text-bold, .text-bold.table td, .text-bold.table th {
    font-weight: 700;
	}
	.text-center {
    text-align: center !important;
	}
	.table-bordered {
    border: 1px solid #dee2e6;
	}
</style>
<div class="table-responsive p-0 text-center">
    <h4><strong>REKAPITULASI LAPORAN KEUANGAN DAN PENCAPAIAN KINERJA SEKRETARIAT DAERAH</strong></h4>
    <h4><strong>APBD KABUPATEN PESISIR BARAT TAHUN ANGGARAN {{$tahun ? $tahun : 'SEMUA TAHUN'}}</strong></h4>
    <h4><strong>BULAN {{$bulan ? strtoupper($bulan) : '-'}}</strong></h4>			
        <table class="table table-bordered" style="border: 2px solid #060606">
            <thead class="text-bold">
                <tr>
                    <td rowspan="3">Program/Kegiatan/Sub Kegiatan</td>
                    <td colspan="15">Anggaran</td>
                </tr>
                <tr>
                    <td colspan="3">Total</td>
                    <td colspan="3">Belanja Operasi</td>
                    <td colspan="3">Belanja Modal</td>
                    <td colspan="3">Belanja Tidak Terduga</td>
                    <td colspan="3">Belanja Transfer</td>
                </tr>
                <tr>
                    <td>Anggaran</td>
                    <td>Realisasi</td>
                    <td>%</td>
                    <td>Anggaran</td>
                    <td>Realisasi</td>
                    <td>%</td>
                    <td>Anggaran</td>
                    <td>Realisasi</td>
                    <td>%</td>
                    <td>Anggaran</td>
                    <td>Realisasi</td>
                    <td>%</td>
                    <td>Anggaran</td>
                    <td>Realisasi</td>
                    <td>%</td>
                </tr>
            </thead>
            <tbody>
							@if ($details->count() > 0)
								@foreach ($details as $item)
								<tr>
									<td>{{$item->program_title.'/'.$item->kegiatan_title.'/'.$item->sub_kegiatan_title}}</td>
									<td>Rp.{{number_format($item->alokasi)}}</td>
									<td>Rp.{{number_format($item->pagu)}}</td>
									<td>{{$item->pagu ? round(($item->pagu/$item->alokasi)*100,1) : 0}}%</td>
									<td>Rp.{{number_format($item->anggaran_belanja_operasi)}}</td>
									<td>Rp.{{number_format($item->pengambilan_belanja_operasi)}}</td>
									<td>{{$item->pengambilan_belanja_operasi ? round(($item->pengambilan_belanja_operasi/$item->anggaran_belanja_operasi)*100,1) : 0}}%</td>
									<td>Rp.{{number_format($item->anggaran_belanja_modal)}}</td>
									<td>Rp.{{number_format($item->pengambilan_belanja_modal)}}</td>
									<td>{{$item->pengambilan_belanja_modal ? round(($item->pengambilan_belanja_modal/$item->anggaran_belanja_modal)*100,1) : 0}}%</td>
									<td>Rp.{{number_format($item->anggaran_belanja_tak_terduga)}}</td>
									<td>Rp.{{number_format($item->pengambilan_belanja_tak_terduga)}}</td>
									<td>{{$item->pengambilan_belanja_tak_terduga ? round(($item->pengambilan_belanja_tak_terduga/$item->anggaran_belanja_tak_terduga)*100,1) : 0}}%</td>
									<td>Rp.{{number_format($item->anggaran_belanja_transfer)}}</td>
									<td>Rp.{{number_format($item->pengambilan_belanja_transfer)}}</td>
									<td>{{$item->pengambilan_belanja_transfer ? round(($item->pengambilan_belanja_transfer/$item->anggaran_belanja_transfer)*100,1) : 0}}%</td>
								</tr>
								@endforeach
							@else
							<tr>
								<td colspan="16"><span>No data available in table</span></td>
							</tr>
							@endif
							<tr class="text-bold">
								<td>Jumlah Belanja Operasi</td>
								<td>Rp.{{number_format($details->sum('anggaran_belanja_operasi'))}}</td>
								<td>Rp.{{number_format($details->sum('pengambilan_belanja_operasi'))}}</td>
								<td>{{$details->sum('pengambilan_belanja_operasi') ? round(($details->sum('pengambilan_belanja_operasi')/$details->sum('anggaran_belanja_operasi'))*100, 1) : 0 }}%</td>
								<td colspan="12"></td>
							</tr>
							<tr class="text-bold">
								<td>Jumlah Belanja Modal</td>
								<td>Rp.{{number_format($details->sum('anggaran_belanja_modal'))}}</td>
								<td>Rp.{{number_format($details->sum('pengambilan_belanja_modal'))}}</td>
								<td>{{$details->sum('pengambilan_belanja_modal') ? round(($details->sum('pengambilan_belanja_modal')/$details->sum('anggaran_belanja_modal'))*100, 1): 0}}%</td>
								<td colspan="12"></td>
							</tr>
							<tr class="text-bold">
								<td>Jumlah Belanja Tidak Terduga</td>
								<td>Rp.{{number_format($details->sum('anggaran_belanja_tak_terduga'))}}</td>
								<td>Rp.{{number_format($details->sum('pengambilan_belanja_tak_terduga'))}}</td>
								<td>{{$details->sum('pengambilan_belanja_tak_terduga') ? round(($details->sum('pengambilan_belanja_tak_terduga')/$details->sum('anggaran_belanja_tak_terduga'))*100, 1): 0}}%</td>
								<td colspan="12"></td>
							</tr>
							<tr class="text-bold">
								<td>Jumlah Belanja Transfer</td>
								<td>Rp.{{number_format($details->sum('anggaran_belanja_transfer'))}}</td>
								<td>Rp.{{number_format($details->sum('pengambilan_belanja_transfer'))}}</td>
								<td>{{$details->sum('pengambilan_belanja_transfer') ? round(($details->sum('pengambilan_belanja_transfer')/$details->sum('anggaran_belanja_transfer'))*100, 1): 0}}%</td>
								<td colspan="12"></td>
							</tr>
							<tr class="text-bold">
								<td>Total</td>
								<td>Rp.{{number_format($details->sum('alokasi'))}}</td>
								<td>Rp.{{number_format($details->sum('pagu'))}}</td>
								<td>{{$details->sum('pagu') ? round(($details->sum('pagu')/$details->sum('alokasi'))*100, 1): 0}}%</td>
								<td colspan="12"></td>
							</tr>
						</tbody>
        </table>
</div>