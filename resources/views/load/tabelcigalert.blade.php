<table class="table table-bordered">
    <tr>
        <th>Nama Mesin</th>
        <th>Value Co2</th>
        <th>Waktu</th>
    </tr>
    @php
        $data = App\Models\Cigalert::orderBy('created_at', 'desc')->limit(10)->get();
        // dd($data);
    @endphp
    @foreach ($data as $d)
    <tr>
        <td>{{ $d->nama_mesin }}</td>
        <td>{{ $d->value }}</td>
        <td>{{ $d->created_at }}</td>
    </tr>
    @endforeach

</table>
