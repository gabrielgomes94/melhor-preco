<li class="nav-item">
    <span class="nav-link tables show d-flex justify-content-between align-items-center">
        <span>
            @isset ($icon)
                <span class="sidebar-icon">
                    <x-layout.icons.icon icon="{{ $icon }}" />
                </span>
            @endisset

            <span class="sidebar-text">{{ $name }}</span>
        </span>
    </span>

    <div class="multi-level tables show"
         role="list"
         aria-expanded="false">

        <ul class="flex-column nav">
            {{ $slot }}
        </ul>
    </div>
</li>
