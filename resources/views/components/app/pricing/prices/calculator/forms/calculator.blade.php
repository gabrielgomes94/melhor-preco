<div class="form-group">
    <form
        method="post"
        action="{{ route('pricing.products.prices.calculate', [$productId, $price['id']]) }}"
        data-price-id="{{ $price['id'] }}"
        class="price-calculator-form"
        enctype="multipart/form-data">
        @csrf

        <x-template.input.read-only
            attribute="store"
            componentId="store-{{ $price['id'] }}"
            label="Marketplace"
            value="{{ $price['storeSlug'] }}"
        >
        </x-template.input.read-only>

        <x-template.input.percentage
            attribute="commission"
            componentId="commission-{{ $price['id'] }}"
            label="Comissão"
            value="{{ $price['mainPrice']['commission'] }}"
        >
        </x-template.input.percentage>

        <x-template.input.percentage
            attribute="discount"
            componentId="discount-{{ $price['id'] }}"
            label="Desconto"
            value=""
        >
        </x-template.input.percentage>

        <x-template.input.percentage
            attribute="desiredPrice"
            componentId="desiredPrice-{{ $price['id'] }}"
            label="Preço desejado"
            value="{{ $price['mainPrice']['value'] }}"
        >
        </x-template.input.percentage>

        <input
            type="hidden"
            name="product"
            id="product-{{ $price['id'] }}"
            value="{{ $productId }}" />


        <div class="d-flex justify-content-center">
            <x-template.buttons.submit label="Calcular" />
        </div>
    </form>
</div>
