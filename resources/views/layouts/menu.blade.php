<ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
    <li class="nav-item"><a class="nav-link {{Route::currentRouteName() == 'admin.dashboard' ? 'active' : ''}}" href="{{route('admin.dashboard')}}" wire:navigate>
      <i class="fa-solid fa-house nav-icon"></i> Dashboard</a>
    </li>
    {{-- <li class="nav-title">Kurikulum</li> --}}
    <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
      <i class="fa-solid fa-school nav-icon"></i> Kurikulum</a>
    <ul class="nav-group-items">
      <li class="nav-item"><a class="nav-link {{Route::currentRouteName() == 'admin.jurusan' ? 'active' : ''}}" href="{{route('admin.jurusan')}}" wire:navigate><span class="nav-icon"></span> Jurusan</a></li>
      <li class="nav-item"><a class="nav-link {{Route::currentRouteName() == 'admin.angkatan' ? 'active' : ''}}" href="{{route('admin.angkatan')}}" wire:navigate> <span class="nav-icon"></span> Angkatan</a></li>
    </ul>
  </li>
  </ul>
