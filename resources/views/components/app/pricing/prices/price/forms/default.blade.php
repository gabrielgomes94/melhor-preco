<div class="form-group">
    <x-bootstrap.forms.form.put
        action="{{ route('pricing.products.prices.update', [$productId, $price['id']]) }}"
    >
        <x-bootstrap.input.read-only
            attribute="value"
            label="Preço"
            componentId="update-price-{{ $price['id'] }}-value"
            value="{{ $price['mainPrice']['value'] }}"
        >
        </x-bootstrap.input.read-only>

        <x-bootstrap.input.read-only
            attribute="purchasePrice"
            label="Preço de Compra"
            componentId="update-price-{{ $price['id'] }}-purchasePrice"
            value=""
        >
        </x-bootstrap.input.read-only>

        <x-bootstrap.input.read-only
            attribute="commission"
            label="Comissão"
            componentId="update-price-{{ $price['id'] }}-commission"
            value=""
        >
        </x-bootstrap.input.read-only>

        <x-bootstrap.input.hidden
            attribute="commissionRate"
            label="Comissão"
            componentId="update-price-{{ $price['id'] }}-commissionRate"
            value="{{ $price['mainPrice']['commission'] }}"
        >
        </x-bootstrap.input.hidden>

        <x-bootstrap.input.read-only
            attribute="freight"
            label="Frete"
            componentId="update-price-{{ $price['id'] }}-freight"
            value=""
        >
        </x-bootstrap.input.read-only>

        <x-bootstrap.input.read-only
            attribute="simplesNacional"
            label="Simples Nacional"
            componentId="update-price-{{ $price['id'] }}-taxSimplesNacional"
            value=""
        >
        </x-bootstrap.input.read-only>

        <x-bootstrap.input.read-only
            attribute="differenceICMS"
            label="Diferença de ICMS"
            componentId="update-price-{{ $price['id'] }}-differenceICMS"
            value=""
        >
        </x-bootstrap.input.read-only>

        <x-bootstrap.input.read-only
            attribute="profit"
            label="Lucro"
            componentId="update-price-{{ $price['id'] }}-profit"
            value="{{ $price['mainPrice']['profit'] }}"
        >
        </x-bootstrap.input.read-only>

        <x-bootstrap.input.read-only
            attribute="margin"
            label="Margem"
            componentId="update-price-{{ $price['id'] }}-margin"
            value="{{ $price['mainPrice']['margin'] }}"
        >
        </x-bootstrap.input.read-only>

        <x-bootstrap.input.read-only
            attribute="storeSlug"
            label="Loja"
            componentId="update-price-{{ $price['id'] }}-store"
            value="{{ $price['storeSlug'] }}"
        >
        </x-bootstrap.input.read-only>

        <div class="d-flex justify-content-center mt-3 mb-2">
            <x-bootstrap.buttons.submit label="Salvar" />
        </div>
    </x-bootstrap.forms.form.put>
</div>
