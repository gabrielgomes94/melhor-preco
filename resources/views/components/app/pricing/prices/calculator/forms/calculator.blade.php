<div class="form-group">
    <form
        method="post"
        action="{{ route('pricing.products.prices.calculate', [$productId, $price['id']]) }}"
        data-price-id="{{ $price['id'] }}"
        class="price-calculator-form"
        enctype="multipart/form-data">
        @csrf

        <div class="mt-2">
            <x-template.input.read-only
                attribute="store"
                componentId="store-{{ $price['id'] }}"
                label="Marketplace"
                value="{{ $price['storeSlug'] }}"
            >
            </x-template.input.read-only>
        </div>

        <div class="mt-2">
            <x-template.input.percentage
                attribute="commission"
                componentId="commission-{{ $price['id'] }}"
                label="Comissão"
                value="{{ $price['mainPrice']['commission'] }}"
            >
            </x-template.input.percentage>
        </div>

        <div class="mt-2">
            <x-template.input.percentage
                attribute="discount"
                componentId="discount-{{ $price['id'] }}"
                label="Desconto"
                value=""
            >
            </x-template.input.percentage>
        </div>

        <div class="mt-2">
            <x-template.input.percentage
                attribute="desiredPrice"
                componentId="desiredPrice-{{ $price['id'] }}"
                label="Preço desejado"
                value="{{ $price['mainPrice']['value'] }}"
            >
            </x-template.input.percentage>
        </div>

        <div class="mt-2">
            <x-bootstrap.forms.input.toggle-switch
                id="freeFreight-{{ $price['id'] }}"
                label="Frete grátis"
                name="freeFreight"
                :isDisabled="$isFreeFreightDisabled"
            >
            </x-bootstrap.forms.input.toggle-switch>
        </div>

        <input
            type="hidden"
            name="product"
            id="product-{{ $price['id'] }}"
            value="{{ $productId }}"
        />

        <div class="d-flex justify-content-center mt-3 mb-2">
            <x-template.buttons.submit label="Calcular" />
        </div>
    </form>
</div>
