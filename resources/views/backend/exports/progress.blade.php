<style>
    table.tb { border-collapse: collapse; width:300px; }
    .tb th, .tb td { padding: 5px; border: solid 1px #777; }
    .tb th { background-color: lightblue;}
</style>

<table class="tb" title="Progress List">

    <thead>
    <tr>
        <td colspan="3" style="text-align: center; font-size: 20px; font-weight: bold">Data Progress Realisasi 2024</td>
    </tr>
    <tr>
        <th>Tanggal</th>
        <th>Keterangan</th>
        <th>Progress</th>
    </tr>
    </thead>
    <tbody>
    @foreach($progress as $val)
        <tr>
            <td>{{ $val->tanggal }}</td>
            <td>{{ $val->keterangan ?? '-' }}</td>
            <td>{{ $val->progress }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
