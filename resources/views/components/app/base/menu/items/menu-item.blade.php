<li class="nav-item">
    <a href="{{$route}}" class="nav-link">
        @isset ($icon)
            <span class="sidebar-icon">
                <x-app.base.icons.icon icon="{{ $icon }}" />
            </span>
        @endisset

        <span class="sidebar-text">{{ $name }}</span>

        @isset ($badge)
            <span class="ms-1">
                <x-bootstrap.badge.badge>
                    {{ $badge }}
                </x-bootstrap.badge.badge>
            </span>
        @endisset
    </a>
</li>
