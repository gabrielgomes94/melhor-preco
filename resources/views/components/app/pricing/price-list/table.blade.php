<div>
    <ul class="list-group">
        <x-app.pricing.price-list.link
            uri="{{ route('pricing.priceList.index') }}"
            content="Por categoria (em breve)"
            disabled="true"
        />

        <x-app.pricing.price-list.link
            uri="{{ route('pricing.priceList.index') }}"
            content="Por produto (em breve)"
            disabled="true"
        />

        <li class="list-group-item">
            <span>Por lojas</span>

            <x-app.pricing.price-list.link
                uri="{{ route('pricing.priceList.byStore', 'b2w') }}"
                content="B2W"
            />

            <x-app.pricing.price-list.link
                uri="{{ route('pricing.priceList.byStore', 'magalu') }}"
                content="Magalu"
            />

            <x-app.pricing.price-list.link
                uri="{{ route('pricing.priceList.byStore', 'mercado_livre') }}"
                content="Mercado Livre"
            />

            <x-app.pricing.price-list.link
                uri="{{ route('pricing.priceList.byStore', 'olist') }}"
                content="Olist"
            />

            <x-app.pricing.price-list.link
                uri="{{ route('pricing.priceList.byStore', 'shopee') }}"
                content="Shopee"
            />
        </li>
    </ul>
</div>
