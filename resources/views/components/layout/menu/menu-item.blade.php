<li class="nav-item">
    <a href="{{$route}}" class="nav-link">
        @isset ($icon)
            <span class="sidebar-icon">
                <x-layout.icons.icon icon="{{ $icon }}" />
            </span>
        @endisset

        <span class="sidebar-text">{{ $name }}</span>

        @isset ($badge)
                <span class="ms-1">
                    <x-utils.badge>
                        {{ $badge }}
                    </x-utils.badge>
                </span>
        @endisset
    </a>
</li>
