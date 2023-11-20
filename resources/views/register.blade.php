
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
                <div class="card">
                    <div class="card-body">
                        <a href="#" class="noble-ui-logo logo-light d-block mb-2">Skulio<span>.Pro</span></a>
                            <h5 class="text-muted fw-normal mb-4">Pendaftaran Skulio.</h5>
                            <?php
                            $nama = '';
                            $username = '';
                            if(isset($_GET['nama_lengkap'])){
                                $nama = $_GET['nama_lengkap'];
                                $username = rand(100,999).strtolower(str_replace(' ','', $_GET['nama_lengkap']));
                            }
                            ?>
                            <form action="" method="get">
                                <div class="mb-3">
                                    <div class="row">
                                        <label for="userEmail" class="form-label">Nama Lengkap</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="nama_lengkap" placeholder="Masukan Nama Lengkap" value="{{ $nama ? ucwords($nama) : ''}}">
                                        </div>
                                        <div class="col-lg-3">
                                            <button class="btn btn-success btn-sm" type="submit">Confirm</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <form class="forms-sample" method="post" action="{{route('register')}}">
                                <input type="text" class="form-control" name="nama_lengkap" value="{{ $nama }}" hidden>
                            <div class="mb-3">
                                <label for="userEmail" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" value="{{ substr($username,0,10) }}" readonly>
                                <div class="text-danger">
                                    @error('username')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="userPassword" class="form-label">No Handphone</label>
                                <input type="text" class="form-control" name="no_hp" autocomplete="current-password" placeholder="Masukan No Hp">
                                <div class="text-danger">
                                    @error('no_hp')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="userPassword" class="form-label">NIS</label>
                                <input type="text" class="form-control" name="nis" autocomplete="current-password" placeholder="Masukan NIS">
                                <div class="text-danger">
                                    @error('nis')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="userPassword" class="form-label">Jenis Kelamin</label>
                                <select name="jenkel" class="form-control">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="l">Laki-laki</option>
                                    <option value="p">Perempuan</option>
                                </select>
                                <div class="text-danger">
                                    @error('jenkel')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="userPassword" class="form-label">Kelas</label>
                                <select name="id_kelas" class="form-control">
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id_kelas }}">{{ $k->tingkat.' '.$k->singkatan.' '.$k->nama_kelas }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger">
                                    @error('id_kelas')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary me-2 mb-2 mb-md-0 text-white" type="submit">Register</button>
                            </div>
                            <a href="{{ route('loginpage') }}" class="d-block mt-3 text-muted">Sudah punya akun? Login disini</a>
                            </form>
                    </div>
                </div>
        </div>
    </div>

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
