<div>
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <form
                        method="post"
                        action="{{ route('pricing.products.prices.calculate', [$pricingId, $productId, $price->id]) }}"
                        data-price-id="{{ $price->id }}"
                        class="price-calculator-form"
                        enctype="multipart/form-data">
                        @csrf

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

                        <div class="d-inline-flex justify-content-between w-100">
                            <x-forms.input.percentage
                                attribute="desiredMargin"
                                id="desiredMargin-{{ $price->id }}"
                                label="Margem"
                                value="{{ $price->margin }}"
                            >
                            </x-forms.input.percentage>

                            <x-forms.input.money
                                attribute="desiredPrice"
                                id="desiredPrice-{{ $price->id }}"
                                label="Preço"
                                value="{{ $price->value }}"
                            >
                            </x-forms.input.money>
                        </div>

                        <input type="hidden"
                               name="product"
                               id="product-{{ $price->id }}"
                               value="{{ $productId }}" />

                        <input type="submit"
                               class="btn btn-dark d-block w-100 mx-auto m-2"
                               value="Calcular" />
                    </form>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <form
                        method="post"
                        action="{{ route('pricing.products.prices.update', [$pricingId, $productId, $price->id]) }}"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <x-forms.input.read-only
                            attribute="value"
                            label="Preço"
                            id="update-price-{{ $price->id }}-value"
                            value="{{ $price->value }}"
                        >
                        </x-forms.input.read-only>

                        <x-forms.input.read-only
                            attribute="profit"
                            label="Lucro"
                            id="update-price-{{ $price->id }}-profit"
                            value="{{ $price->profit }}"
                        >
                        </x-forms.input.read-only>

                        <x-forms.input.read-only
                            attribute="margin"
                            label="Margem"
                            id="update-price-{{ $price->id }}-margin"
                            value="{{ $price->margin }}"
                        >
                        </x-forms.input.read-only>

                        <input type="submit"
                               class="btn btn-dark d-block w-100 mx-auto m-2"
                               value="Salvar" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
