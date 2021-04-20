<div>
    <div class="form-group">
        <h4>{{ $productInfo->name }}</h4>

        <x-forms.form.put
            action="{{ route('pricing.products.update', [$pricingId, $productInfo->id]) }}"
        >
            <x-forms.input.money
                attribute="purchasePrice"
                label="Preço de Compra"
                value="{{ $productInfo->purchasePrice }}"
            >
            </x-forms.input.money>

            <x-forms.input.percentage
                attribute="taxIPI"
                label="Imposto IPI"
                value="{{ $productInfo->taxIPI }}"
            >
            </x-forms.input.percentage>

            <x-forms.input.percentage
                attribute="taxICMS"
                label="Imposto ICMS"
                value="{{ $productInfo->taxICMS }}"
            >
            </x-forms.input.percentage>

            <x-forms.input.percentage
                attribute="taxSimplesNacional"
                label="Imposto Simples Nacional"
                value="{{ $productInfo->taxSimplesNacional }}"
            >
            </x-forms.input.percentage>

            <x-forms.input.money
                attribute="additionalCosts"
                label="Custos Adicionais"
                value="{{ $productInfo->additionalCosts }}"
            >
            </x-forms.input.money>

            <input type="submit"
                   class="btn btn-dark d-block w-100 mx-auto m-2"
                   value="Atualizar" />
        </x-forms.form.put>
    </div>
</div>
