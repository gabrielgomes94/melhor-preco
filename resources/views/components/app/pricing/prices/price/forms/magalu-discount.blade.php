<div class="form-group">
    <x-template.input.read-only
        attribute="value"
        label="Preço com desconto"
        componentId="discounted-price-{{ $price['id'] }}-value"
        value="{{ $price['secondaryPrice']['value'] }}"
    >
    </x-template.input.read-only>

    <x-template.input.read-only
        attribute="purchasePrice"
        label="Preço de Compra"
        componentId="discounted-price-{{ $price['id'] }}-purchasePrice"
        value=""
    >
    </x-template.input.read-only>

    <x-template.input.read-only
        attribute="commission"
        label="Comissão"
        componentId="discounted-price-{{ $price['id'] }}-commission"
        value=""
    >
    </x-template.input.read-only>

    <x-template.input.read-only
        attribute="freight"
        label="Frete"
        componentId="discounted-price-{{ $price['id'] }}-freight"
        value=""
    >
    </x-template.input.read-only>

    <x-template.input.read-only
        attribute="simplesNacional"
        label="Simples Nacional"
        componentId="discounted-price-{{ $price['id'] }}-taxSimplesNacional"
        value=""
    >
    </x-template.input.read-only>

    <x-template.input.read-only
        attribute="differenceICMS"
        label="Diferença de ICMS"
        componentId="discounted-price-{{ $price['id'] }}-differenceICMS"
        value=""
    >
    </x-template.input.read-only>

    <x-template.input.read-only
        attribute="profit"
        label="Lucro"
        componentId="discounted-price-{{ $price['id'] }}-profit"
        value="{{ $price['secondaryPrice']['profit'] }}"
    >
    </x-template.input.read-only>

    <x-template.input.read-only
        attribute="margin"
        label="Margem"
        componentId="discounted-price-{{ $price['id'] }}-margin"
        value="{{ $price['secondaryPrice']['margin'] }}"
    >
    </x-template.input.read-only>
</div>
