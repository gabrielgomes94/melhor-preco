<div>
    <div class="form-group">
        <h3>{{ $productInfo->sku() }} - {{ $productInfo->name() }}</h3>

        <x-forms.form.put action="{{ route('products.costs.update', $productInfo->sku()) }}">
            <x-forms.input.money
                attribute="purchasePrice"
                componentId="purchasePrice-{{ $productInfo->sku() }}"
                label="Preço de Custo"
                value="{{ $productInfo->purchasePrice() }}"
            >
            </x-forms.input.money>

            <x-forms.input.percentage
                attribute="taxICMS"
                componentId="taxICMS-{{ $productInfo->sku() }}"
                label="Imposto ICMS"
                value="{{ $productInfo->taxICMS() }}"
            >
            </x-forms.input.percentage>

            <x-forms.input.money
                attribute="additionalCosts"
                componentId="additionalCosts-{{ $productInfo->sku() }}"
                label="Custos Adicionais"
                value="{{ $productInfo->additionalCosts() }}"
            >
            </x-forms.input.money>

            <input type="submit"
                   class="btn btn-dark d-block w-100 mx-auto m-2"
                   value="Atualizar" />
        </x-forms.form.put>
    </div>
</div>
