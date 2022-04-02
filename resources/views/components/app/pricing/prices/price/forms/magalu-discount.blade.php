<div class="form-group">
    <x-bootstrap.forms.input.read-only
        attribute="value"
        label="Preço com desconto"
        componentId="discounted-price-{{ $price['id'] }}-value"
        value="{{ $price['secondaryPrice']['value'] }}"
    >
    </x-bootstrap.forms.input.read-only>

    <x-bootstrap.forms.input.read-only
        attribute="purchasePrice"
        label="Preço de Compra"
        componentId="discounted-price-{{ $price['id'] }}-purchasePrice"
        value=""
    >
    </x-bootstrap.forms.input.read-only>

    <x-bootstrap.forms.input.read-only
        attribute="commission"
        label="Comissão"
        componentId="discounted-price-{{ $price['id'] }}-commission"
        value=""
    >
    </x-bootstrap.forms.input.read-only>

    <x-bootstrap.forms.input.read-only
        attribute="freight"
        label="Frete"
        componentId="discounted-price-{{ $price['id'] }}-freight"
        value=""
    >
    </x-bootstrap.forms.input.read-only>

    <x-bootstrap.forms.input.read-only
        attribute="simplesNacional"
        label="Simples Nacional"
        componentId="discounted-price-{{ $price['id'] }}-taxSimplesNacional"
        value=""
    >
    </x-bootstrap.forms.input.read-only>

    <x-bootstrap.forms.input.read-only
        attribute="differenceICMS"
        label="Diferença de ICMS"
        componentId="discounted-price-{{ $price['id'] }}-differenceICMS"
        value=""
    >
    </x-bootstrap.forms.input.read-only>

    <x-bootstrap.forms.input.read-only
        attribute="profit"
        label="Lucro"
        componentId="discounted-price-{{ $price['id'] }}-profit"
        value="{{ $price['secondaryPrice']['profit'] }}"
    >
    </x-bootstrap.forms.input.read-only>

    <x-bootstrap.forms.input.read-only
        attribute="margin"
        label="Margem"
        componentId="discounted-price-{{ $price['id'] }}-margin"
        value="{{ $price['secondaryPrice']['margin'] }}"
    >
    </x-bootstrap.forms.input.read-only>
</div>
