<div class="form-group">
    <form
        method="get"
        action="{{
            route(
                'pricing.products.calculate',
                [
                    $calculatorForm['marketplaceSlug'],
                    $calculatorForm['productId']
                ])
                }}"
        data-price-id="{{ $calculatorForm['priceId'] }}"
        class="price-calculator-form"
        enctype="multipart/form-data">
        @csrf

        <div class="mt-2">
            <x-bootstrap.forms.input.read-only
                name="store"
                id="store-{{ $calculatorForm['priceId'] }}"
                label="Marketplace"
                value="{{ $calculatorForm['marketplaceSlug'] }}"
            >
            </x-bootstrap.forms.input.read-only>
        </div>

        <div class="mt-2">
            <x-bootstrap.forms.input.percentage
                name="commission"
                id="commission-{{ $calculatorForm['priceId'] }}"
                label="Comissão"
                value="{{ $calculatorForm['commission'] }}"
            >
            </x-bootstrap.forms.input.percentage>
        </div>

        <div class="mt-2">
            <x-bootstrap.forms.input.percentage
                name="discount"
                id="discount-{{ $calculatorForm['priceId'] }}"
                label="Desconto"
                value="{{ $calculatorForm['discount'] }}"
            >
            </x-bootstrap.forms.input.percentage>
        </div>

        <div class="mt-2">
            <x-bootstrap.forms.input.percentage
                name="desiredPrice"
                id="desiredPrice-{{ $calculatorForm['priceId'] }}"
                label="Preço desejado"
                value="{{ $calculatorForm['desiredPrice'] }}"
            >
            </x-bootstrap.forms.input.percentage>
        </div>

        <div class="mt-2">
            <x-bootstrap.forms.input.toggle-switch
                id="freeFreight-{{ $calculatorForm['priceId'] }}"
                label="Frete grátis"
                name="freeFreight"
                :isDisabled="$calculatorForm['isFreeFreightDisabled']"
            >
            </x-bootstrap.forms.input.toggle-switch>
        </div>

        <input
            type="hidden"
            name="product"
            id="product-{{ $calculatorForm['priceId'] }}"
            value="{{ $calculatorForm['productId'] }}"
        />

        <div class="d-flex justify-content-center mt-3 mb-2">
            <x-bootstrap.buttons.submit label="Calcular" />
        </div>
    </form>
</div>
