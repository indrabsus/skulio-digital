
@php
$currentMenu = null;
@endphp

@foreach ($menus as $menu)
    @if ($menu->parent_menu !== $currentMenu)
        @php
        $currentMenu = $menu->parent_menu;
        @endphp

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#{{ $menu->nama_menu }}" role="button" aria-expanded="false" aria-controls="{{ str_replace(' ', '', strtolower($menu->nama_menu)) }}">
                <i class="link-icon" data-feather="{{$menu->icon}}"></i>
                <span class="link-title">{{ ucwords($menu->parent_menu) }}</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="{{ $menu->nama_menu }}">
                <ul class="nav sub-menu">
    @endif

    <li class="nav-item">
        <a href="{{ route($menu->nama_role.'.'.strtolower(str_replace(' ','', $menu->nama_menu))) }}" class="nav-link">
            <span class="link-title" style="margin-left: 10px;">{{ $menu->nama_menu }}</span>
        </a>
    </li>

    @if ($loop->last || $menu->parent_menu !== $menus[$loop->index + 1]->parent_menu)
                </ul>
            </div>
        </li>
    @endif
@endforeach


