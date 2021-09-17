<li class="nav-item ">
    <a href="{{$route}}" class="nav-link">
        @isset ($icon)
            <span class="sidebar-icon">
                <x-layout.icons.icon icon="{{ $icon }}" />
            </span>
        @endisset

        <span class="sidebar-text">{{ $name }}</span>

        @isset ($badge)
            <span>
                <span class="badge badge-sm bg-secondary ms-1 text-gray-800">{{ $badge }}</span>
            </span>
        @endisset
    </a>
</li>
