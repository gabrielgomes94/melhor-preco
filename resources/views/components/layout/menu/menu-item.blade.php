<li class="nav-item ">
    <a href="{{$route}}" class="nav-link">
        <span class="sidebar-icon">
            <svg class="icon icon-xs me-2"
                 fill="currentColor"
                 viewBox="0 0 20 20"
                 xmlns="http://www.w3.org/2000/svg">

                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
            </svg>
        </span>

        <span class="sidebar-text">{{ $name }}</span>

        @isset ($badge)
            <span>
                <span class="badge badge-sm bg-secondary ms-1 text-gray-800">{{ $badge }}</span>
            </span>
        @endisset
    </a>
</li>
