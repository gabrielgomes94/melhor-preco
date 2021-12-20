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
                <x-template.badge.badge>
                    {{ $badge }}
                </x-template.badge.badge>
            </span>
        @endisset

        <span class="notifications-badge-section"></span>
    </a>
</li>
