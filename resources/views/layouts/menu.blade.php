<li class="nav-item">
  <a href="{{route('admin.dashboard')}}" class="nav-link">
    <i class="link-icon" data-feather="home"></i>
    <span class="link-title">Dashboard</span>
  </a>
</li>

@php
$currentMenu = null;
@endphp

@foreach ($menus as $menu)
    @if ($menu->nama_role !== $currentMenu)
        @php
        $currentMenu = $menu->nama_role;
        @endphp

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#{{ $menu->nama_menu }}" role="button" aria-expanded="false" aria-controls="{{ $menu->nama_menu }}">
                <i class="link-icon" data-feather="{{$menu->icon}}"></i>
                <span class="link-title">{{ ucwords($menu->nama_role) }}</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="{{ $menu->nama_menu }}">
                <ul class="nav sub-menu">
    @endif

    <li class="nav-item">
        <a href="{{ route($menu->name) }}" class="nav-link">
            <span class="link-title" style="margin-left: 10px;">{{ $menu->nama_menu }}</span>
        </a>
    </li>

    @if ($loop->last || $menu->nama_role !== $menus[$loop->index + 1]->nama_role)
                </ul>
            </div>
        </li>
    @endif
@endforeach


