
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                            <h5 class="text-muted fw-normal mb-4">Masukan no whatsapp...!!!</h5>
                            <form class="forms-sample" method="post" action="{{route('wapost')}}" target="_blank">
                                <div class="input-group input-group-sm mb-3">
                                      <input type="text" class="form-control" name="nowa" placeholder="Contoh : 08123456789" aria-label="Username" aria-describedby="basic-addon1" wire:model.live="cari">
                                      <button class="input-group-text" id="basic-addon1"><i class="fa-brands fa-whatsapp"></i></button>
                                    </div>
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
