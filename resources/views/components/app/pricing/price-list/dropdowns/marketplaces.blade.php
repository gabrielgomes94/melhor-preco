<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle"
            type="button"
            id="dropdownMenuButton1"
            data-bs-toggle="dropdown"
            aria-expanded="false"
    >
        Marketplaces
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        @foreach ($marketplaces ?? [] as $marketplace)
            <li>
                <a class="dropdown-item" href="{{ route('pricing.priceList.byStore', $marketplace['slug'])  }}">
                    {{ $marketplace['name'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
