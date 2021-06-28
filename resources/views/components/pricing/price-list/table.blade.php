<div>
    <ul class="list-group">
        <x-pricing.price-list.link
            uri="{{ route('pricing.priceList.all') }}"
            content="Por categoria (em breve)"
            disabled="true"
        />

        <x-pricing.price-list.link
            uri="{{ route('pricing.priceList.all') }}"
            content="Por produto (em breve)"
            disabled="true"
        />

        <li class="list-group-item">
            <span>Por lojas</span>

            <x-pricing.price-list.link
                uri="{{ route('pricing.priceList.byStore', 'b2w') }}"
                content="B2W"
            />

            <x-pricing.price-list.link
                uri="{{ route('pricing.priceList.byStore', 'magalu') }}"
                content="Magalu"
            />

            <x-pricing.price-list.link
                uri="{{ route('pricing.priceList.byStore', 'mercado_livre') }}"
                content="Mercado Livre"
            />

            <x-pricing.price-list.link
                uri="{{ route('pricing.priceList.byStore', 'olist') }}"
                content="Olist"
            />

            <x-pricing.price-list.link
                uri="{{ route('pricing.priceList.byStore', 'shopee') }}"
                content="Shopee"
            />
        </li>

        <x-pricing.price-list.link
            uri="{{ route('pricing.priceList.custom') }}"
            content="Listas customizadas"
        />
    </ul>
</div>
