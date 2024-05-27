<table class="table table-stripped">
    <tr>
        <th>Nama</th>
        <th>Waktu</th>
        <th>Status</th>
    </tr>
    @foreach ($log as $l => $d)
        <tr>
            <td>
                @php
                    $cek = App\Models\DataUser::where('id_user', $d['uid'])->first();
                @endphp
                {{ $cek == NULL ? 'User tidak ditemukan' : $cek->nama_lengkap}}</td>
            <td>{{ date('d F Y - h:i:s A', strtotime($d['timestamp'])) }}</td>
            <td>{{ $d['type'] == 0 ? 'Datang' : 'Pulang' }}</td>
        </tr>
        @endforeach
</table>
