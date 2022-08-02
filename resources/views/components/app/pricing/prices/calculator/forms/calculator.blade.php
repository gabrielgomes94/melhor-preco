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
        data-price-id="{{ $priceId }}"
        class="price-calculator-form"
        enctype="multipart/form-data">
        @csrf

        <div class="mt-2">
            <x-bootstrap.forms.input.hidden
                name="store"
                id="store-{{ $priceId }}"
                value="{{ $calculatorForm['marketplaceSlug'] }}"
            >
            </x-bootstrap.forms.input.hidden>
        </div>

        <div class="mt-2">
            <x-bootstrap.forms.input.money
                name="desiredPrice"
                id="desiredPrice-{{ $priceId }}"
                label="Preço desejado"
                value="{{ $calculatorForm['desiredPrice'] }}"
            >
            </x-bootstrap.forms.input.money>
        </div>

        <div class="mt-2">
            <x-bootstrap.forms.input.percentage
                name="discount"
                id="discount-{{ $priceId }}"
                label="Desconto (%)"
                value="{{ $calculatorForm['discount'] }}"
            >
            </x-bootstrap.forms.input.percentage>
        </div>

        <div class="mt-2">
            <x-bootstrap.forms.input.percentage
                name="commission"
                id="commission-{{ $priceId }}"
                label="Comissão (%)"
                value="{{ $calculatorForm['commission'] }}"
            >
            </x-bootstrap.forms.input.percentage>
        </div>

        <div class="mt-2">
            <x-bootstrap.forms.input.money
                name="freight"
                id="freight-{{ $priceId }}"
                label="Frete"
                value="{{ $calculatorForm['freight'] ?? null }}"
            >
            </x-bootstrap.forms.input.money>
        </div>

        <input
            type="hidden"
            name="product"
            id="product-{{ $priceId }}"
            value="{{ $calculatorForm['productId'] }}"
        />

        <div class="d-flex justify-content-between m-3 mb-2">
            <div class="m-1">
                <x-bootstrap.links.link-primary
                    route="{{
                    route(
                        'pricing.products.calculate',
                        [
                            $calculatorForm['marketplaceSlug'],
                            $calculatorForm['productId']
                        ])
                        }}"
                >
                    Limpar
                </x-bootstrap.links.link-primary>
            </div>

            <x-bootstrap.buttons.submit label="Calcular" />
        </div>
    </form>
</div>
