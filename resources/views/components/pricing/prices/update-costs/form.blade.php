<x-template.card.card>

    <x-forms.form.put action="{{ route('products.costs.update', $sku) }}">
        <h5 class="text-center mb-2">Atualizar custos</h5>

        <x-forms.input.money
            attribute="purchasePrice"
            componentId="purchasePrice-{{ $sku }}"
            label="Preço de Custo"
            value="{{ $purchasePrice }}"
        >
        </x-forms.input.money>

        <x-forms.input.percentage
            attribute="taxICMS"
            componentId="taxICMS-{{ $sku }}"
            label="Imposto ICMS"
            value="{{ $taxICMS }}"
        >
        </x-forms.input.percentage>

        <x-forms.input.money
            attribute="additionalCosts"
            componentId="additionalCosts-{{ $sku }}"
            label="Custos Adicionais"
            value="{{ $additionalCosts }}"
        >
        </x-forms.input.money>

        <div class="d-flex justify-content-center mt-2">
            <x-template.buttons.submit label="Atualizar" />
        </div>
    </x-forms.form.put>
</x-template.card.card>
