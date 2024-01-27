<div>
    {{ Route::currentRouteName() }}
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card card-outline card-danger">
                <div class="card-header">
                  <h3 class="card-title">Absensi Online</h3>
                </div>
                <div class="card-body">
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

                <form action="{{ route('ayoabsen') }}" method="post">
                    @csrf
                    <input type="text" name="id_user" value="{{ Auth::user()->id }}" hidden>

                    <div class="form-group mb-3">
                        <label for="">Lokasi saya</label>

                        <div class="row">
                            <div class="col-6"><input type="text" name="lat" id="lat" class="form-control" readonly></div>
                            <div class="col-6"><input type="text" name="long" id="long" class="form-control" readonly></div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ Auth::user()->username }}" class="form-control" readonly>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <button class="btn btn-primary btn-block">Absen</button>
                        </div>
                    </div>
                </form>
                </div>
                <!-- /.card-body -->
              </div>
        </div>
    </div>


    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }
        getLocation()
        function showPosition(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            document.getElementById('lat').value = latitude
            document.getElementById('long').value = longitude

            var url = "https://maps.google.com/maps?q="+latitude+", "+longitude+"&z=15&output=embed"
                document.getElementById('myFrame').src = url
        }

    </script>
</div>
