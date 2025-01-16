<table class="table table-striped table-responsive-sm">
    <tr>
        <th>No</th>
        <th>Nama Lengkap</th>
        <th>Hadir</th>
        @if ($role == 7)
        <th>Pulang</th>
        @endif
        <th>Sakit</th>
        <th>Izin</th>
        <th>Libur</th>
        <th>Persentase</th>
        <th>Bulan</th>
    </tr>
    <?php $no=1; ?>
    <?php
                        $maxHadir = 0; // Inisialisasi variabel untuk menyimpan nilai maksimal kehadiran dari semua user

                        // Menghitung total hadir, nojadwal, dan mencari kehadiran maksimal dari semua user
                        foreach ($data as $d) {
                            $hadir = App\Models\Absen::where('id_user', $d->id)->where('status', 0)->where('waktu', 'like', '%' . $bulan . '%')->count();
                            $pulang = App\Models\Absen::where('id_user', $d->id)->where('status', 4)->where('waktu', 'like', '%' . $bulan . '%')->count();
                            $nojadwal = App\Models\Absen::where('id_user', $d->id)->where('status', 1)->where('waktu', 'like', '%' . $bulan . '%')->count();

                            // Menghitung total kehadiran berdasarkan role
                            if ($d->nama_role == 'guru') {
                                $thadir = $hadir;
                            } else if ($d->nama_role == 'tendik') {
                                $thadir = $hadir + $pulang;
                            } else {
                                $thadir = $hadir + $nojadwal + $pulang;
                            }

                            // Memperbarui nilai kehadiran maksimal jika nilai saat ini lebih besar
                            $maxHadir = max($maxHadir, $thadir);
                        }
                        ?>

                        @foreach ($data as $d)
                            @php
                            $hadir = App\Models\Absen::where('id_user', $d->id)->where('status', 0)->where('waktu', 'like', '%' . $bulan . '%')->count();
                            $pulang = App\Models\Absen::where('id_user', $d->id)->where('status', 4)->where('waktu', 'like', '%' . $bulan . '%')->count();
                            $nojadwal = App\Models\Absen::where('id_user', $d->id)->where('status', 1)->where('waktu', 'like', '%' . $bulan . '%')->count();
                            $sakit = App\Models\Absen::where('id_user', $d->id)->where('status', 2)->where('waktu', 'like', '%' . $bulan . '%')->count();
                            $izin = App\Models\Absen::where('id_user', $d->id)->where('status', 3)->where('waktu', 'like', '%' . $bulan . '%')->count();
                            // Menghitung total kehadiran berdasarkan role
                            if ($d->nama_role == 'guru') {
                                    $thadir = $hadir;
                                } else if ($d->nama_role == 'tendik') {
                                    $thadir = $hadir + $pulang;
                                } else {
                                    $thadir = $hadir + $nojadwal + $pulang;
                                }

                                // Hitung persentase kehadiran berdasarkan nilai maksimal dari semua user
                                $persen = ($maxHadir > 0) ? ($thadir / $maxHadir) * 100 : 0;
                            @endphp

                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $d->nama_lengkap }}</td>
                        <td>{{ $hadir }}</td>
                        @if ($role == 7)
                        <td>{{ $pulang }}</td>
                        @endif
                        <td>{{ $sakit }}</td>
                        <td>{{ $izin }}</td>
                        <td>{{ $nojadwal }}</td>
                        <td>{{ round($persen, 2) }}%</td>
                        <td>{{ $bulan }}</td>
                    </tr>
                    @endforeach

</table>
