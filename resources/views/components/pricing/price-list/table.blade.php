<div>
    <ul class="list-group">
        <x-pricing.price-list.link
            uri="{{ route('pricing.priceList.all') }}"
            content="Por categoria"
            disabled="true"
        />

        <x-pricing.price-list.link
            uri="{{ route('pricing.priceList.all') }}"
            content="Por produto"
            disabled="true"
        />

        <li class="list-group-item">
            <span>Por lojas</span>

            <x-pricing.price-list.link
                uri="{{ route('pricing.priceList.all') }}"
                content="B2W"
            />

            <x-pricing.price-list.link
                uri="{{ route('pricing.priceList.all') }}"
                content="Magalu"
            />

            <x-pricing.price-list.link
                uri="{{ route('pricing.priceList.all') }}"
                content="Mercado Livre"
            />

            <x-pricing.price-list.link
                uri="{{ route('pricing.priceList.all') }}"
                content="Olist"
            />

            <x-pricing.price-list.link
                uri="{{ route('pricing.priceList.all') }}"
                content="Shoppee"
            />
        </li>
    </ul>
</div>
