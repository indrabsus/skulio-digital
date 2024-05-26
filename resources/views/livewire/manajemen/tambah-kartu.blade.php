<div>
    <div class="row">
        <div class="col-lg-4">
            <form action="{{ route('insertuser') }}" method="post">
                <div id="cekkartu"></div>
                <input type="text" name="id_user" class="form-control" value="{{ $data->id_user }}" hidden>
                <div class="form-group mb-3">
                    <label for="">Kode Mesin</label>
                    <input type="text" name="kode_mesin" class="form-control" value="{{ Session::get('kode_mesin') }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="{{ $data->nama_lengkap }}" readonly>
                </div>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </form>
        </div>
    </div>


        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                            setInterval(function() {
                                fetch("{{route('inputscan')}}")
                                    .then(response => response.text())
                                    .then(html => {
                                        document.getElementById("cekkartu").innerHTML = html;
                                    })
                                    .catch(error => console.error('Error loading content:', error));
                            }, 1000);
                        });
        </script>

</div>
