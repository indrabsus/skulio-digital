
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
                        <div class="container">
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
                        <a href="#" class="noble-ui-logo logo-light d-block mb-2">Skulio<span>.Pro</span></a>
                            <h5 class="text-muted fw-normal mb-4">Lupa Username</h5>
                            <form class="forms-sample" method="get" action="">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="userEmail" class="form-label">NIS</label>
                                            <input type="text" class="form-control" name="nis" placeholder="Masukan NIS" value="{{old('nis')}}">
                                            <div class="text-danger">
                                                @error('nis')
                                                    {{$message}}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="userPassword" class="form-label">No Hp</label>
                                            <input type="text" class="form-control" name="no_hp" value="{{old('no_hp')}}" placeholder="Masukan No Hp">
                                            <div class="text-danger">
                                                @error('no_hp')
                                                    {{$message}}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            <div>
                                <button class="btn btn-primary me-2 mb-2 mb-md-0 text-white" type="submit">Cek Username</button>
                            </div>
                            </form>
                            @if (isset($_GET['nis']) && $_GET['no_hp'])
                                @php
                                    $data = DB::table('users')->leftJoin('data_siswa','data_siswa.id_user','users.id')->where('data_siswa.nis',$_GET['nis'])->where('no_hp', $_GET['no_hp'])->first();
                                @endphp
                            @else
                                @php
                                    $data= NULL;
                                @endphp
                            @endif
                            @if (isset($data))
                            <div class="mb-3 mt-3">
                                <input type="text" class="form-control" name="username" placeholder="Username Anda" value="{{$data->username}}" disabled>
                                <div class="text-danger">
                                    @error('username')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                            @else
                            <div class="mb-3 mt-3">
                                <input type="text" class="form-control" name="username" placeholder="Username Anda" value="User tidak ditemukan!" disabled>
                                <div class="text-danger">
                                    @error('username')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                            @endif
                            <a href="{{ route('loginpage') }}" class="d-block mt-3 text-muted">Kembali ke Halaman Login</a>
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
