<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle"
            type="button"
            id="marketplacesListDropdown"
            data-bs-toggle="dropdown"
            aria-expanded="false"
    >
        Marketplaces

        <x-app.base.icons.dropdown-arrow />
    </button>
    <ul class="dropdown-menu" aria-labelledby="marketplacesListDropdown">
        @foreach ($marketplaces ?? [] as $marketplace)
            <li>
                <a class="dropdown-item" href="{{ route('pricing.priceList.byStore', $marketplace['slug'])  }}">
                    {{ $marketplace['name'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
