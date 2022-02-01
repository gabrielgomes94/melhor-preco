<nav class="navbar navbar-expand mb-3 border-bottom border-gray-400">
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            @foreach ($marketplaces as $marketplace)
                <li class="nav-item px-2">
                    <a class="nav-link {{ $selected == $marketplace['slug'] ? 'active' : '' }}"
                       href={{ route('pricing.priceList.byStore', $marketplace['slug'])  }}>
                        {{ $marketplace['name'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</nav>
