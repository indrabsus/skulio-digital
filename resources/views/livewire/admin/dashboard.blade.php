<div>
    <div>
        @if(session('sukses'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h5>Sukses!</h5>
        {{session('sukses')}}
        </div>
        @endif
        @if(session('gagal'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h5>Gagal!</h5>
        {{session('gagal')}}
        </div>
        @endif
    </div>
    <h3>Selamat Datang di Skulio Pro</h3>
    <hr>
    <p>Aplikasi ini dibuat oleh Tim IT SMK Sangkuriang 1 Cimahi. Dalam aplikasi skulio, rekan-rekan bisa mengatur Manajemen Informasi seputar sekolah</p>
    <p>Silakan gunakan aplikasi Skulio Pro dengan Bijak</p>
</div>
