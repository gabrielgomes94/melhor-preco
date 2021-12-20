<ul class="list-group list-group-flush">
    <li class="list-group-item " aria-current="true">
        <a href="{{ route('pricing.priceList.byStore', $store->slug()) }}?filterKits=1">
            Apenas Kits de Produtos
        </a>
    </li>
    <li class="list-group-item">
        <a href="{{ route('pricing.priceList.byStore', $store->slug()) }}">
            Todos os Produtos
        </a>
    </li>
</ul>
