<div class="form-group">
    <x-forms.input.read-only
            attribute="value"
            label="Preço (5% de desconto)"
            id="discounted-price-{{ $price->id }}-value"
            value="{{ $price->discountedPrice }}"
    >
    </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="purchasePrice"
            label="Preço de Compra"
            id="discounted-price-{{ $price->id }}-purchasePrice"
            value=""
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="commission"
            label="Comissão"
            id="discounted-price-{{ $price->id }}-commission"
            value=""
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="freight"
            label="Frete"
            id="discounted-price-{{ $price->id }}-freight"
            value=""
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="simplesNacional"
            label="Simples Nacional"
            id="discounted-price-{{ $price->id }}-simplesNacional"
            value=""
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="differenceICMS"
            label="Diferença de ICMS"
            id="discounted-price-{{ $price->id }}-differenceICMS"
            value=""
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="profit"
            label="Lucro"
            id="discounted-price-{{ $price->id }}-profit"
            value="{{ $price->profit }}"
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="margin"
            label="Margem"
            id="discounted-price-{{ $price->id }}-margin"
            value="{{ $price->margin }}"
        >
        </x-forms.input.read-only>
</div>
