<div>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
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
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <x-forms.form.put
                        action="{{ route('pricing.products.prices.update', [$pricingId, $productId, $price->id]) }}"
                    >
                        <x-forms.input.read-only
                            attribute="value"
                            label="Preço"
                            id="update-price-{{ $price->id }}-value"
                            value="{{ $price->value }}"
                        >
                        </x-forms.input.read-only>

                        <x-forms.input.read-only
                            attribute="purchasePrice"
                            label="Preço de Compra"
                            id="update-price-{{ $price->id }}-purchasePrice"
                            value=""
                        >
                        </x-forms.input.read-only>

                        <x-forms.input.read-only
                            attribute="commission"
                            label="Comissão"
                            id="update-price-{{ $price->id }}-commission"
                            value=""
                        >
                        </x-forms.input.read-only>

                        <x-forms.input.read-only
                            attribute="freight"
                            label="Frete"
                            id="update-price-{{ $price->id }}-freight"
                            value=""
                        >
                        </x-forms.input.read-only>

                        <x-forms.input.read-only
                            attribute="simplesNacional"
                            label="Simples Nacional"
                            id="update-price-{{ $price->id }}-simplesNacional"
                            value=""
                        >
                        </x-forms.input.read-only>

                        <x-forms.input.read-only
                            attribute="differenceICMS"
                            label="Diferença de ICMS"
                            id="update-price-{{ $price->id }}-differenceICMS"
                            value=""
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

                        <x-forms.input.read-only
                            attribute="storeSlug"
                            label="Loja"
                            id="update-price-{{ $price->id }}-store"
                            value="{{ $price->storeSlug }}"
                        >
                        </x-forms.input.read-only>

                        <input type="submit"
                               class="btn btn-dark d-block w-100 mx-auto m-2"
                               value="Salvar" />
                    </x-forms.form.put>
                </div>
            </div>
        </div>
    </div>
</div>
