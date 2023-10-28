<li class="nav-item nav-category">Admin</li>
<li class="nav-item">
  <a href="{{route('admin.dashboard')}}" class="nav-link">
    <i class="link-icon" data-feather="home"></i>
    <span class="link-title">Dashboard</span>
  </a>
</li>

<li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#angkatan" role="button" aria-expanded="false" aria-controls="angkatan">
      <i class="link-icon" data-feather="anchor"></i>
      <span class="link-title">Kurikulum</span>
      <i class="link-arrow" data-feather="chevron-down"></i>
    </a>
    <div class="collapse" id="angkatan">
      <ul class="nav sub-menu">
        <li class="nav-item">
          <a href="{{route('admin.angkatan')}}" class="nav-link">Angkatan</a>
        </li>
        <li class="nav-item">
          <a href="{{route('admin.jurusan')}}" class="nav-link">Jurusan</a>
        </li>
        <li class="nav-item">
          <a href="{{route('admin.kelas')}}" class="nav-link">Kelas</a>
        </li>
        <li class="nav-item">
          <a href="{{route('admin.mapel')}}" class="nav-link">Mata Pelajaran</a>
        </li>
      </ul>
    </div>
  </li>

  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#angkatan" role="button" aria-expanded="false" aria-controls="angkatan">
      <i class="link-icon" data-feather="anchor"></i>
      <span class="link-title">Sarpras</span>
      <i class="link-arrow" data-feather="chevron-down"></i>
    </a>
    <div class="collapse" id="angkatan">
      <ul class="nav sub-menu">
        <li class="nav-item">
          <a href="{{route('admin.ruangan')}}" class="nav-link">Ruangan</a>
        </li>
      </ul>
    </div>
  </li>
