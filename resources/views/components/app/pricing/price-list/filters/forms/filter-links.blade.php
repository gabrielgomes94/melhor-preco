<ul class="list-group list-group-flush">
    <li class="list-group-item " aria-current="true">
        <a href="{{ route('pricing.priceList.byStore', $marketplaceSlug) }}?filterKits=1"
           class="link"
        >
            Apenas Kits de Produtos
        </a>
    </li>
    <li class="list-group-item">
        <a href="{{ route('pricing.priceList.byStore', $marketplaceSlug) }}"
           class="link"
        >
            Todos os Produtos
        </a>
    </li>
</ul>
