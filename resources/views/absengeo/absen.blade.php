<!DOCTYPE html>
<!--
Template Name: NobleUI - HTML Bootstrap 5 Admin Dashboard Template
Author: NobleUI
Website: https://www.nobleui.com
Portfolio: https://themeforest.net/user/nobleui/portfolio
Contact: nobleui123@gmail.com
Purchase: https://1.envato.market/nobleui_admin
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
  <style>
    .centered-container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
  </style>


	<title>{{env('APP_NAME')}}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- End fonts -->

	<!-- core:css -->
	<link rel="stylesheet" href="{{asset('template')}}/assets/vendors/core/core.css">
	<!-- endinject -->

	<!-- Plugin css for this page -->
	<!-- End plugin css for this page -->

	<!-- inject:css -->
	<link rel="stylesheet" href="{{asset('template')}}/assets/fonts/feather-font/css/iconfont.css">
	<link rel="stylesheet" href="{{asset('template')}}/assets/vendors/flag-icon-css/css/flag-icon.min.css">
	<!-- endinject -->

  <!-- Layout styles -->
	<link rel="stylesheet" href="{{asset('template')}}/assets/css/demo2/style.css">
  <!-- End layout styles -->

  <link rel="shortcut icon" href="{{asset('template')}}/assets/images/favicon.png" />
  <style>
    .justify-content-center{
      display: flex;
      align-content: center;
      align-items: center;
      height: 100vh;
    }
  </style>
</head>
<body>
<div class="row justify-content-center">
    <div class="col-lg-4">
        <div class="card card-outline card-danger">
            <div class="card-header">
              <h3 class="card-title">Absensi Online</h3>
            </div>
            <div class="card-body">
                @if (session('sukses'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                    {{ session('sukses') }}
                </div>
            @endif
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

<!-- core:js -->
<script src="{{asset('template')}}/assets/vendors/core/core.js"></script>
<!-- endinject -->

<!-- Plugin js for this page -->
<!-- End plugin js for this page -->

<!-- inject:js -->
<script src="{{asset('template')}}/assets/vendors/feather-icons/feather.min.js"></script>
<script src="{{asset('template')}}/assets/js/template.js"></script>
<!-- endinject -->

<!-- Custom js for this page -->
<!-- End custom js for this page -->

</body>
</html>
