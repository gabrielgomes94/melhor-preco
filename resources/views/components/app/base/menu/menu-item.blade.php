<li class="nav-item mx-2">
    <a href="{{$route}}" class="nav-link p-0 m-1 w-100">
        <div class="d-flex flex-row justify-content-around">
            @isset ($icon)
                <div class="sidebar-icon">
                    <x-app.base.icons.icon icon="{{ $icon }}" />
                </div>
            @endisset

            <div class="sidebar-text">{{ $name }}</div>
        </div>


        @isset ($badge)
                <span class="ms-1">
                    <x-bootstrap.badge.badge>
                        {{ $badge }}
                    </x-bootstrap.badge.badge>
                </span>
        @endisset
    </a>
</li>
