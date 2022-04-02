<x-bootstrap.card.basic.card>
    <x-bootstrap.card.basic.card-body>
        <div class="form-group">
            <x-bootstrap.forms.form.put action="{{ route('costs.product.update', $product->getSku()) }}">
                <h5 class="text-center mb-2">Atualizar custos</h5>

                <x-bootstrap.forms.input.money
                    attribute="purchasePrice"
                    componentId="purchasePrice-{{ $product->getSku() }}"
                    label="Preço de Custo"
                    value="{{ $product->getCosts()->purchasePrice() }}"
                >
                </x-bootstrap.forms.input.money>

                <x-bootstrap.forms.input.percentage
                    attribute="taxICMS"
                    id="taxICMS-{{ $product->getSku() }}"
                    label="Imposto ICMS"
                    value="{{ $product->getCosts()->taxICMS() }}"
                >
                </x-bootstrap.forms.input.percentage>

                <x-bootstrap.forms.input.money
                    attribute="additionalCosts"
                    id="additionalCosts-{{ $product->getSku() }}"
                    label="Custos Adicionais"
                    value="{{ $product->getCosts()->additionalCosts() }}"
                >
                </x-bootstrap.forms.input.money>

                <div class="d-flex justify-content-center mt-3 mb-2">
                    <x-bootstrap.buttons.submit label="Atualizar" />
                </div>
            </x-bootstrap.forms.form.put>
        </div>
    </x-bootstrap.card.basic.card-body>
</x-bootstrap.card.basic.card>
