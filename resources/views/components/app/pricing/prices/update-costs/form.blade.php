<x-template.card.card>
    <x-template.forms.put action="{{ route('costs.product.update', $sku) }}">
        <h5 class="text-center mb-2">Atualizar custos</h5>

        <x-template.input.money
            attribute="purchasePrice"
            componentId="purchasePrice-{{ $sku }}"
            label="Preço de Custo"
            value="{{ $purchasePrice }}"
        >
        </x-template.input.money>

        <x-template.input.percentage
            attribute="taxICMS"
            componentId="taxICMS-{{ $sku }}"
            label="Imposto ICMS"
            value="{{ $taxICMS }}"
        >
        </x-template.input.percentage>

        <x-template.input.money
            attribute="additionalCosts"
            componentId="additionalCosts-{{ $sku }}"
            label="Custos Adicionais"
            value="{{ $additionalCosts }}"
        >
        </x-template.input.money>

        <div class="d-flex justify-content-center mt-2">
            <x-template.buttons.submit label="Atualizar" />
        </div>
    </x-template.forms.put>
</x-template.card.card>
