
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

        <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center"><img src="https://i.ibb.co.com/cxt589x/689cf9ca-777e-4f42-b7d9-4d15a60ceee9.png" width="100px"></div>
                        <h1 class="text-center">SMK Sangkuriang 1 Cimahi</h1>
                        <h2 class="text-center">Penerimaan Siswa Baru 2024</h2>
                        <table class="table table-bordered mt-3">
                            <tr>
                                <td>Jumlah Pendaftar Total</td><th>{{ $all }} Siswa</th>
                            </tr>
                            {{-- <tr>
                                <td>Kuota Sekolah</td><th>432 Siswa</th>
                            </tr>
                            <tr>
                                <td>Sisa</td><th>{{ 432 - $all }} Siswa</th>
                            </tr> --}}
                        </table>
                        <table class="table table-bordered mt-3">
                            <tr>
                                <th>Jurusan</th>
                                <th>Pendaftar</th>
                                <th>Antrian</th>
                                {{-- <th>Belum Bayar Pendaftaran</th> --}}
                                <th>Kelas Terisi</th>
                                <th>Tersisa</th>
                            </tr>

                            <tr>
                                <td>AKUNTANSI</td>
                                <td>{{ $ak }} Siswa</td>
                                <td>{{ $ak_a }} Siswa</td>
                                {{-- <td>{{ $akuntansi }} Siswa</td> --}}
                                <td>
                                    @if ($ak + $ak_a <= 36)
                                        1 Kelas
                                    @elseif ($ak + $ak_a > 36 && $ak + $ak_a <= 72)
                                        2 Kelas
                                    @elseif ($ak + $ak_a > 72 && $ak + $ak_a <= 108)
                                        3 Kelas
                                    @else
                                        4 Kelas
                                    @endif
                                </td>
                                <td>
                                    @if ($ak + $ak_a <= 36)
                                        {{ 36 - ($ak + $ak_a) }} Siswa
                                    @elseif ($ak + $ak_a > 36 && $ak + $ak_a <= 72)
                                        {{ 72 - ($ak + $ak_a) }} Siswa
                                    @elseif ($ak + $ak_a > 72 && $ak + $ak_a <= 108)
                                        {{ 108 - ($ak + $ak_a) }} Siswa
                                    @else
                                        {{ 144 - ($ak + $ak_a) }} Siswa
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td>PPLG</td>
                                <td>{{ $rpl }} Siswa</td>
                                <td>{{ $rpl_a }} Siswa</td>
                                {{-- <td>{{ $pplg }} Siswa</td> --}}
                                <td>
                                    @if ($rpl + $rpl_a <= 36)
                                        1 Kelas
                                    @elseif ($rpl + $rpl_a > 36 && $rpl + $rpl_a <= 72)
                                        2 Kelas
                                    @elseif ($rpl + $rpl_a > 72 && $rpl + $rpl_a <= 108)
                                        3 Kelas
                                    @else
                                        4 Kelas
                                    @endif
                                </td>
                                <td>
                                    @if ($rpl + $rpl_a <= 36)
                                        {{ 36 - ($rpl + $rpl_a) }} Siswa
                                    @elseif ($rpl + $rpl_a > 36 && $rpl + $rpl_a <= 72)
                                        {{ 72 - ($rpl + $rpl_a) }} Siswa
                                    @elseif ($rpl + $rpl_a > 72 && $rpl + $rpl_a <= 108)
                                        {{ 108 - ($rpl + $rpl_a) }} Siswa
                                    @else
                                        {{ 144 - ($rpl + $rpl_a) }} Siswa
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td>Pemasaran</td>
                                <td>{{ $pm }} Siswa</td>
                                <td>{{ $pm_a }} Siswa</td>
                                {{-- <td>{{ $bisnis }} Siswa</td> --}}
                                <td>
                                    @if ($pm + $pm_a <= 36)
                                        1 Kelas
                                    @elseif ($pm + $pm_a > 36 && $pm + $pm_a <= 72)
                                        2 Kelas
                                    @elseif ($pm + $pm_a > 72 && $pm + $pm_a <= 108)
                                        3 Kelas
                                    @else
                                        4 Kelas
                                    @endif
                                </td>
                                <td>
                                    @if ($pm + $pm_a <= 36)
                                        {{ 36 - ($pm + $pm_a) }} Siswa
                                    @elseif ($pm + $pm_a > 36 && $pm + $pm_a <= 72)
                                        {{ 72 - ($pm + $pm_a) }} Siswa
                                    @elseif ($pm + $pm_a > 72 && $pm + $pm_a <= 108)
                                        {{ 108 - ($pm + $pm_a) }} Siswa
                                    @else
                                        {{ 144 - ($pm + $pm_a) }} Siswa
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td>MPLB</td>
                                <td>{{ $mp }} Siswa</td>
                                <td>{{ $mp_a }} Siswa</td>
                                {{-- <td>{{ $mplb }} Siswa</td> --}}
                                <td>
                                    @if ($mp + $mp_a <= 36)
                                        1 Kelas
                                    @elseif ($mp + $mp_a > 36 && $mp + $mp_a <= 72)
                                        2 Kelas
                                    @elseif ($mp + $mp_a > 72 && $mp + $mp_a <= 108)
                                        3 Kelas
                                    @else
                                        4 Kelas
                                    @endif
                                </td>
                                <td>
                                    @if ($mp + $mp_a <= 36)
                                        {{ 36 - ($mp + $mp_a) }} Siswa
                                    @elseif ($mp + $mp_a > 36 && $mp + $mp_a <= 72)
                                        {{ 72 - ($mp + $mp_a) }} Siswa
                                    @elseif ($mp + $mp_a > 72 && $mp + $mp_a <= 108)
                                        {{ 108 - ($mp + $mp_a) }} Siswa
                                    @else
                                        {{ 144 - ($mp+ $mp_a) }} Siswa
                                    @endif
                                </td>
                            </tr>
                        </table>


                        <p class="mt-3">Note: Jumlah pendaftar tidak semua dimasukan kedalam kelas dikarenakan masih ada tunggakan administrasi</p>
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
