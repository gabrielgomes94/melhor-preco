<div class="form-group">
    <form
        method="post"
        action="{{ route('pricing.products.prices.calculate', [$pricingId, $productId, $price->id]) }}"
        data-price-id="{{ $price->id }}"
        class="price-calculator-form"
        enctype="multipart/form-data">
        @csrf

        <x-forms.input.read-only
            attribute="store"
            id="store-{{ $price->id }}"
            label="Marketplace"
            value="{{ $price->storeSlug }}"
        >
        </x-forms.input.read-only>

        <x-forms.input.percentage
            attribute="commission"
            id="commission-{{ $price->id }}"
            label="Comissão"
            value="{{ $price->commission }}"
        >
        </x-forms.input.percentage>

        <x-forms.input.money
            attribute="additionalCosts"
            id="additionalCosts-{{ $price->id }}"
            label="Custos Adicionais"
            value="{{ $price->additionalCosts }}"
        >
        </x-forms.input.money>

        <x-forms.input.money
            attribute="desiredPrice"
            id="desiredPrice-{{ $price->id }}"
            label="Preço desejado"
            value="{{ $price->value }}"
        >
        </x-forms.input.money>

        <input type="hidden"
               name="product"
               id="product-{{ $price->id }}"
               value="{{ $productId }}" />

        <input type="submit"
               class="btn btn-dark d-block w-100 mx-auto m-2"
               value="Calcular" />
    </form>
</div>
