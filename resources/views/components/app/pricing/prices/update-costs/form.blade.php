<div class="form-group">
    <x-bootstrap.forms.form.put action="{{ route('costs.product.update', $productId) }}">
        <div class="mt-2">
            <x-bootstrap.forms.input.money
                attribute="purchasePrice"
                componentId="purchasePrice-{{ $productId }}"
                label="Preço de Custo"
                value="{{ $costs['purchasePrice'] }}"
            />
        </div>

        <div class="mt-2">
            <x-bootstrap.forms.input.percentage
                attribute="taxICMS"
                id="taxICMS-{{ $productId }}"
                label="Imposto ICMS (%)"
                value="{{ $costs['taxICMS'] }}"
            />
        </div>

        <div class="mt-2">
            <x-bootstrap.forms.input.money
                attribute="additionalCosts"
                componentId="additionalCosts-{{ $productId }}"
                label="Custos Adicionais"
                value="{{ $costs['additionalCosts'] }}"
            >
            </x-bootstrap.forms.input.money>
        </div>

        <div class="d-flex justify-content-center mt-3 mb-2">
            <x-bootstrap.buttons.submit label="Atualizar" />
        </div>
    </x-bootstrap.forms.form.put>
</div>
