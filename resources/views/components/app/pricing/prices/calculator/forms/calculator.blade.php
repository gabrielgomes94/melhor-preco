<div class="form-group">
    <form
        method="get"
        action="{{ route('pricing.products.calculate', [$marketplaceSlug, $productId]) }}"
        data-price-id="{{ $priceId }}"
        class="price-calculator-form"
        enctype="multipart/form-data">
        @csrf

        <div class="mt-2">
            <x-bootstrap.forms.input.read-only
                name="store"
                id="store-{{ $priceId }}"
                label="Marketplace"
                value="{{ $marketplaceSlug }}"
            >
            </x-bootstrap.forms.input.read-only>
        </div>

        <div class="mt-2">
            <x-bootstrap.forms.input.percentage
                name="commission"
                id="commission-{{ $priceId }}"
                label="Comissão"
                value="{{ $commission }}"
            >
            </x-bootstrap.forms.input.percentage>
        </div>

        <div class="mt-2">
            <x-bootstrap.forms.input.percentage
                name="discount"
                id="discount-{{ $priceId }}"
                label="Desconto"
                value="{{ $discount }}"
            >
            </x-bootstrap.forms.input.percentage>
        </div>

        <div class="mt-2">
            <x-bootstrap.forms.input.percentage
                name="desiredPrice"
                id="desiredPrice-{{ $priceId }}"
                label="Preço desejado"
                value="{{ $desiredPrice }}"
            >
            </x-bootstrap.forms.input.percentage>
        </div>

        <div class="mt-2">
            <x-bootstrap.forms.input.toggle-switch
                id="freeFreight-{{ $priceId }}"
                label="Frete grátis"
                name="freeFreight"
                :isDisabled="$isFreeFreightDisabled"
            >
            </x-bootstrap.forms.input.toggle-switch>
        </div>

        <input
            type="hidden"
            name="product"
            id="product-{{ $priceId }}"
            value="{{ $productId }}"
        />

        <div class="d-flex justify-content-center mt-3 mb-2">
            <x-bootstrap.buttons.submit label="Calcular" />
        </div>
    </form>
</div>
