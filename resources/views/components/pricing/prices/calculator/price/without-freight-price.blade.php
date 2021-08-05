<div class="form-group">
    <x-forms.input.read-only
        attribute="value"
        label="Preço "
        componentId="discounted-price-{{ $price->id }}-value"
        value="{{ $secondaryPrice['price'] }}"
    >
    </x-forms.input.read-only>

    <x-forms.input.read-only
        attribute="purchasePrice"
        label="Preço de Compra"
        componentId="discounted-price-{{ $price->id }}-purchasePrice"
        value=""
    >
    </x-forms.input.read-only>

    <x-forms.input.read-only
        attribute="commission"
        label="Comissão"
        componentId="discounted-price-{{ $price->id }}-commission"
        value=""
    >
    </x-forms.input.read-only>

    <x-forms.input.read-only
        attribute="freight"
        label="Frete (sem frete)"
        componentId="discounted-price-{{ $price->id }}-freight"
        value=""
    >
    </x-forms.input.read-only>

    <x-forms.input.read-only
        attribute="simplesNacional"
        label="Simples Nacional"
        componentId="discounted-price-{{ $price->id }}-simplesNacional"
        value=""
    >
    </x-forms.input.read-only>

    <x-forms.input.read-only
        attribute="differenceICMS"
        label="Diferença de ICMS"
        componentId="discounted-price-{{ $price->id }}-differenceICMS"
        value=""
    >
    </x-forms.input.read-only>

    <x-forms.input.read-only
        attribute="profit"
        label="Lucro"
        componentId="discounted-price-{{ $price->id }}-profit"
        value="{{ $secondaryPrice['profit'] }}"
    >
    </x-forms.input.read-only>

    <x-forms.input.read-only
        attribute="margin"
        label="Margem"
        componentId="discounted-price-{{ $price->id }}-margin"
        value="{{ $secondaryPrice['margin'] }}"
    >
    </x-forms.input.read-only>
</div>
