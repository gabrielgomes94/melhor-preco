<x-template.card.card>
    <x-template.card.card-body>
        <div class="form-group">
            <x-template.forms.put action="{{ route('costs.product.update', $product->getSku()) }}">
                <h5 class="text-center mb-2">Atualizar custos</h5>

                <x-template.input.money
                    attribute="purchasePrice"
                    componentId="purchasePrice-{{ $product->getSku() }}"
                    label="Preço de Custo"
                    value="{{ $product->getCosts()->purchasePrice() }}"
                >
                </x-template.input.money>

                <x-template.input.percentage
                    attribute="taxICMS"
                    componentId="taxICMS-{{ $product->getSku() }}"
                    label="Imposto ICMS"
                    value="{{ $product->getCosts()->taxICMS() }}"
                >
                </x-template.input.percentage>

                <x-template.input.money
                    attribute="additionalCosts"
                    componentId="additionalCosts-{{ $product->getSku() }}"
                    label="Custos Adicionais"
                    value="{{ $product->getCosts()->additionalCosts() }}"
                >
                </x-template.input.money>

                <div class="d-flex justify-content-center mt-3 mb-2">
                    <x-template.buttons.submit label="Atualizar" />
                </div>
            </x-template.forms.put>
        </div>
    </x-template.card.card-body>
</x-template.card.card>
