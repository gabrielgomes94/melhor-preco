<li class="nav-item">
    <span class="nav-link tables show d-flex justify-content-between align-items-center"
          data-bs-toggle="collapse"
          data-bs-target="#submenu-app"
    >
        <span>
            @isset ($icon)
                <span class="sidebar-icon">
                    <x-layout.icons.icon icon="{{ $icon }}" />
                </span>
            @endisset

            <span class="sidebar-text">{{ $name }}</span>
        </span>

        <span class="link-arrow">
            <x-layout.icons.arrow />
        </span>
    </span>

    <div class="multi-level collapse tables show"
         role="list"
         id="submenu-app"
         aria-expanded="false">

        <ul class="flex-column nav">
            {{ $slot }}
        </ul>
    </div>
</li>
