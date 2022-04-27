<li class="nav-item">
    <a href="{{$route}}" class="nav-link p-2 m-1 w-100">
            @isset ($icon)
                <span class="sidebar-icon">
                    <x-app.base.icons.icon icon="{{ $icon }}" />
                </span>
            @endisset

            <span class="sidebar-text">{{ $name }}</span>
    </a>
</li>
