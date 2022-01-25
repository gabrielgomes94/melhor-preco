<div class="form-group">
    <x-template.forms.put
        action="{{ route('pricing.products.prices.update', [$productId, $price['id']]) }}"
    >
        <x-template.input.read-only
            attribute="value"
            label="Preço"
            componentId="update-price-{{ $price['id'] }}-value"
            value="{{ $price['mainPrice']['value'] }}"
        >
        </x-template.input.read-only>

        <x-template.input.read-only
            attribute="purchasePrice"
            label="Preço de Compra"
            componentId="update-price-{{ $price['id'] }}-purchasePrice"
            value=""
        >
        </x-template.input.read-only>

        <x-template.input.read-only
            attribute="commission"
            label="Comissão"
            componentId="update-price-{{ $price['id'] }}-commission"
            value=""
        >
        </x-template.input.read-only>

        <x-template.input.hidden
            attribute="commissionRate"
            label="Comissão"
            componentId="update-price-{{ $price['id'] }}-commission-rate"
            value="{{ $price['mainPrice']['commissionRate'] ?? 10.0 }}"
        >
        </x-template.input.hidden>

        <x-template.input.read-only
            attribute="freight"
            label="Frete"
            componentId="update-price-{{ $price['id'] }}-freight"
            value=""
        >
        </x-template.input.read-only>

        <x-template.input.read-only
            attribute="simplesNacional"
            label="Simples Nacional"
            componentId="update-price-{{ $price['id'] }}-simplesNacional"
            value=""
        >
        </x-template.input.read-only>

        <x-template.input.read-only
            attribute="differenceICMS"
            label="Diferença de ICMS"
            componentId="update-price-{{ $price['id'] }}-differenceICMS"
            value=""
        >
        </x-template.input.read-only>

        <x-template.input.read-only
            attribute="profit"
            label="Lucro"
            componentId="update-price-{{ $price['id'] }}-profit"
            value="{{ $price['mainPrice']['profit'] }}"
        >
        </x-template.input.read-only>

        <x-template.input.read-only
            attribute="margin"
            label="Margem"
            componentId="update-price-{{ $price['id'] }}-margin"
            value="{{ $price['mainPrice']['margin'] }}"
        >
        </x-template.input.read-only>

        <x-template.input.read-only
            attribute="storeSlug"
            label="Loja"
            componentId="update-price-{{ $price['id'] }}-store"
            value="{{ $price['storeSlug'] }}"
        >
        </x-template.input.read-only>

        <div class="d-flex justify-content-center">
            <x-template.buttons.submit label="Salvar" />
        </div>
    </x-template.forms.put>
</div>
