<div class="form-group">
    <form
        method="post"
        action="{{ route('pricing.products.prices.calculate', [$productId, $data['id']]) }}"
        data-price-id="{{ $data['id'] }}"
        class="price-calculator-form"
        enctype="multipart/form-data">
        @csrf

        <x-template.input.read-only
            attribute="store"
            componentId="store-{{ $data['id'] }}"
            label="Marketplace"
            value="{{ $data['storeSlug'] }}"
        >
        </x-template.input.read-only>

        <x-template.input.percentage
            attribute="commission"
            componentId="commission-{{ $data['id'] }}"
            label="Comissão"
            value="{{ $data['mainPrice']['commission'] }}"
        >
        </x-template.input.percentage>

        <x-template.input.percentage
            attribute="discount"
            componentId="discount-{{ $data['id'] }}"
            label="Desconto"
            value=""
        >
        </x-template.input.percentage>

        <x-template.input.percentage
            attribute="desiredPrice"
            componentId="desiredPrice-{{ $data['id'] }}"
            label="Preço desejado"
            value="{{ $data['mainPrice']['value'] }}"
        >
        </x-template.input.percentage>

        <input
            type="hidden"
            name="product"
            id="product-{{ $data['id'] }}"
            value="{{ $productId }}" />


        <div class="d-flex justify-content-center">
            <x-template.buttons.submit label="Calcular" />
        </div>
    </form>
</div>
