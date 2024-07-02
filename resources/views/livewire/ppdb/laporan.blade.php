<div>
    <h3>Laporan PPDB</h3>
    <div class="row mt-3">
        <div class="col-lg-6">
            <table class="table table-bordered">
                <tr>
                    <td>Pendaftar Total</td><td>{{$pendaftar}}</td>
                </tr>
                <tr>
                    <td>Hanya Daftar (Belum bayar Apapun)</td><td>{{$hanyadaftar}}</td>
                </tr>
                <tr>
                    <td>Bayar Pendaftaran (Rp.150.000)</td><td>{{$hanyadaftar}}</td>
                </tr>
                <tr>
                    <td>Total Siswa yang sudah Bayar Pendaftaran</td><td>{{$sudahdaftar}}</td>
                </tr>
                <tr>
                    <td>Kurang dari Rp.1000.000 (Sudah Bayar)</td><td>{{$kurangsejuta}}</td>
                </tr>
                <tr>
                    <td>Lebih dari Rp.1000.000 (Belum Lunas)</td><td>{{$lebihsejuta}}</td>
                </tr>
                <tr>
                    <td>Mengundurkan Diri</td><td>{{$mengundurkan}}</td>
                </tr>
                <tr>
                    <td>Lunas</td><td>{{$lunas}}</td>
                </tr>
            </table>
        </div>
        <div class="col-lg-6">
            <table class="table table-bordered">
                <tr>
                    <td>Total Pendaftaran</td><td>Rp. {{number_format($uangdaftar,0,',','.')}}</td>
                </tr>
                <tr>
                    <td>Total PPDB</td><td>Rp. {{number_format($uangppdb,0,',','.')}}</td>
                </tr>
                <tr>
                    <td>Mengundurkan Diri</td><td>Rp. {{number_format($uangundur,0,',','.')}}</td>
                </tr>
                <tr>
                    <td>Total semua uang masuk</td><td>Rp. {{number_format($uangdaftar + $uangppdb + $uangundur,0,',','.')}}</td>
                </tr>

            </table>
        </div>
    </div>
</div>
