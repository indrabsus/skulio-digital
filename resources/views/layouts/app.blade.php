<!DOCTYPE html>
<!--
Template Name: NobleUI - HTML Bootstrap 5 Admin Dashboard Template
Author: NobleUI
-->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  	<meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<title>{{env('APP_NAME')}}</title>

	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
  	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

	<!-- core:css -->
	<link rel="stylesheet" href="{{asset('template')}}/assets/vendors/core/core.css">

	<!-- Plugin css for this page -->
  	<link rel="stylesheet" href="{{asset('template')}}/assets/vendors/flatpickr/flatpickr.min.css">

	<!-- inject:css -->
	<link rel="stylesheet" href="{{asset('template')}}/assets/fonts/feather-font/css/iconfont.css">
	<link rel="stylesheet" href="{{asset('template')}}/assets/vendors/flag-icon-css/css/flag-icon.min.css">

	<!-- Layout styles -->
	<link rel="stylesheet" href="{{asset('template')}}/assets/css/demo2/style.css">

  	<link rel="shortcut icon" href="{{asset('template')}}/assets/images/favicon.png" />
  	<style>
    	table {
        	width: 100%;
    	}
    	.wrapped-text {
        	max-width: 200px;
        	word-break: break-word;
    	}

    	/* Default overlay yang tersembunyi */
    	.loading-overlay {
        	position: fixed;
        	top: 0;
        	left: 0;
        	width: 100%;
        	height: 100%;
        	background: rgba(0, 0, 0, 0.5);
        	display: none;
        	justify-content: center;
        	align-items: center;
        	z-index: 9999;
        	color: white;
        	font-size: 24px;
    	}

    	/* Tampilkan overlay saat wire:loading */
    	.show-overlay {
        	display: flex;
    	}
  	</style>
</head>
<body>

	@php
    	$menus = App\Models\Menu::leftJoin('parent_menu','parent_menu.id_parent','menu.parent_menu')
			->leftJoin('roles','roles.id_role','menu.akses_role')
			->where('id_role', Auth::user()->id_role)
    		->orderBy('id_parent', 'asc')
    		->orderBy('menu.nama_menu', 'asc')->get();
	@endphp

	<div class="main-wrapper">
		<!-- Sidebar -->
		<nav class="sidebar">
      		<div class="sidebar-header">
        		<a href="{{ env('APP_URL') }}" class="sidebar-brand">
          			Skulio<span>.Pro</span>
        		</a>
        		<div class="sidebar-toggler not-active">
          			<span></span>
          			<span></span>
          			<span></span>
        		</div>
      		</div>
      		<div class="sidebar-body">
        		<ul class="nav">
         			@include('layouts.menu')
        		</ul>
      		</div>
    	</nav>

		<div class="page-wrapper">
			<!-- Navbar -->
			<nav class="navbar">
				<a href="#" class="sidebar-toggler">
					<i data-feather="menu"></i>
				</a>
				<div class="navbar-content">
					<form class="search-form">
						<div class="input-group">
              				<div class="input-group-text">
                				<i data-feather="search"></i>
              				</div>
							<input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
						</div>
					</form>
					<ul class="navbar-nav">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<img class="wd-30 ht-30 rounded-circle" src="{{asset('template/assets/images/avatars/user.png')}}" alt="profile">
							</a>
							<div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
								<div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
									<div class="mb-3">
										<img class="wd-80 ht-80 rounded-circle" src="{{asset('template/assets/images/avatars/user.png')}}" alt="">
									</div>
									<div class="text-center">
										<p class="tx-16 fw-bolder">{{Auth::user()->username}}</p>
									</div>
								</div>
                				<ul class="list-unstyled p-1">
                  					<li class="dropdown-item py-2">
                    					<a href="{{ route('ubahpassword') }}" class="text-body ms-0">
                      						<i class="me-2 icon-md" data-feather="edit"></i>
                      						<span>Ubah Password</span>
                    					</a>
                  					</li>
                  					<li class="dropdown-item py-2">
                    					<a href="{{route('logout')}}" class="text-body ms-0">
                      						<i class="me-2 icon-md" data-feather="log-out"></i>
                      						<span>Log Out</span>
                    					</a>
                  					</li>
                				</ul>
							</div>
						</li>
					</ul>
				</div>
			</nav>

			<!-- Page content -->
			<div class="page-content">
        		<div class="row">
          			<div class="col-12 col-xl-12 grid-margin stretch-card">
            			<div class="card overflow-hidden">
              				<div class="card-body">
               					{{$slot}}
              				</div>
            			</div>
          			</div>
        		</div> <!-- row -->
        		@livewireScripts
			</div>

			<!-- Footer -->
			<footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between px-4 py-3 border-top small">
				<p class="text-muted mb-1 mb-md-0">Copyright © <?= date('Y') ?> <a href="https://www.batara.art" target="_blank">Skulio Pro</a>.</p>
				<p class="text-muted">Powered by Indra Batara</p>
			</footer>

		</div>
	</div>

	<!-- Global Loading Overlay -->
	<div wire:loading.class="show-overlay" class="loading-overlay">
		<div class="loading-text">
			Loading data...
		</div>
	</div>

	<!-- core:js -->
	<script src="{{asset('template')}}/assets/vendors/core/core.js"></script>

	<!-- Plugin js for this page -->
  	<script src="{{asset('template')}}/assets/vendors/flatpickr/flatpickr.min.js"></script>
  	<script src="{{asset('template')}}/assets/vendors/apexcharts/apexcharts.min.js"></script>

	<!-- inject:js -->
	<script src="{{asset('template')}}/assets/vendors/feather-icons/feather.min.js"></script>
	<script src="{{asset('template')}}/assets/js/template.js"></script>

	<!-- Custom js for this page -->
  	<script src="{{asset('template')}}/assets/js/dashboard-light.js"></script>
</body>
</html>
