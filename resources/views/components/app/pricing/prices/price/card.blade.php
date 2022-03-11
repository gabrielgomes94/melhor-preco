<x-template.card.card class="h-100">
    <x-template.card.card-body>
        <x-app.pricing.prices.price.card-header :post="$price"/>

{{--        <x-app.pricing.prices.price.forms.default :productId="$productId" :price="$price"/>--}}

        <x-app.pricing.prices.price.calculated-price.table :productId="$productId" :price="$price"/>

{{--        TODO: mover para um formulário próprio--}}
        <x-template.forms.put
            action="{{ route('pricing.products.prices.update', [$productId, $price['id']]) }}"
        >
            <x-template.input.read-only
                attribute="value"
                label="Preço"
                componentId="update-price-{{ $price['id'] }}-value"
                value="{{ $price['mainPrice']['value'] }}"
            >
            </x-template.input.read-only>

            <x-template.input.read-only
                attribute="storeSlug"
                label="Loja"
                componentId="update-price-{{ $price['id'] }}-store"
                value="{{ $price['storeSlug'] }}"
            >
            </x-template.input.read-only>

            <div class="d-flex justify-content-center mt-3 mb-2">
                <x-template.buttons.submit label="Salvar" />
            </div>
        </x-template.forms.put>
    </x-template.card.card-body>
</x-template.card.card>
