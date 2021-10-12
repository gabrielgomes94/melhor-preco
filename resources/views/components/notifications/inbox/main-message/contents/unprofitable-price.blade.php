<div>
    <h4>{{ $notification->content()['productName'] }}</h4>

    <h6>Preço: R$ {{ $notification->content()['price'] }}</h6>
    <h6>Prejuízo: R$ {{ $notification->content()['profit'] }}</h6>
    <h6>Marketplace: {{ $notification->content()['store'] ?? "" }}</h6>

    <a href="{{ route('pricing.products.showByStore', [
                'store' => $notification->content()['storeSlug'],
                'product_id' => $notification->content()['productId'],
            ]) }}"
        class="text-info"
    >
        Link para calculadora
    </a>
</div>
