<div class="form-group">
    <x-forms.form.put
        action="{{ route('pricing.products.prices.update', [$productId, $price['id']]) }}"
    >
        <x-forms.input.read-only
            attribute="value"
            label="Preço"
            componentId="update-price-{{ $price['id'] }}-value"
            value="{{ $price['value'] }}"
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="purchasePrice"
            label="Preço de Compra"
            componentId="update-price-{{ $price['id'] }}-purchasePrice"
            value=""
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="commission"
            label="Comissão"
            componentId="update-price-{{ $price['id'] }}-commission"
            value=""
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="freight"
            label="Frete"
            componentId="update-price-{{ $price['id'] }}-freight"
            value=""
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="simplesNacional"
            label="Simples Nacional"
            componentId="update-price-{{ $price['id'] }}-simplesNacional"
            value=""
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="differenceICMS"
            label="Diferença de ICMS"
            componentId="update-price-{{ $price['id'] }}-differenceICMS"
            value=""
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="profit"
            label="Lucro"
            componentId="update-price-{{ $price['id'] }}-profit"
            value="{{ $price['profit'] }}"
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="margin"
            label="Margem"
            componentId="update-price-{{ $price['id'] }}-margin"
            value="{{ $price['margin'] }}"
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="storeSlug"
            label="Loja"
            componentId="update-price-{{ $price['id'] }}-store"
            value="{{ $price['storeSlug'] }}"
        >
        </x-forms.input.read-only>

        <div class="d-flex justify-content-center">
            <x-template.buttons.submit label="Salvar" />
        </div>
    </x-forms.form.put>
</div>
