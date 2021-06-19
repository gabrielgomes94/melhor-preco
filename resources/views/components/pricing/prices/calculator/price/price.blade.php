<div class="form-group">
    <x-forms.form.put
        action="{{ route('pricing.products.prices.update', [$pricingId, $productId, $price->id]) }}"
    >
        <x-forms.input.read-only
            attribute="value"
            label="Preço"
            id="update-price-{{ $price->id }}-value"
            value="{{ $price->value }}"
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="purchasePrice"
            label="Preço de Compra"
            id="update-price-{{ $price->id }}-purchasePrice"
            value=""
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="commission"
            label="Comissão"
            id="update-price-{{ $price->id }}-commission"
            value=""
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="freight"
            label="Frete"
            id="update-price-{{ $price->id }}-freight"
            value=""
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="simplesNacional"
            label="Simples Nacional"
            id="update-price-{{ $price->id }}-simplesNacional"
            value=""
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="differenceICMS"
            label="Diferença de ICMS"
            id="update-price-{{ $price->id }}-differenceICMS"
            value=""
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="profit"
            label="Lucro"
            id="update-price-{{ $price->id }}-profit"
            value="{{ $price->profit }}"
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="margin"
            label="Margem"
            id="update-price-{{ $price->id }}-margin"
            value="{{ $price->margin }}"
        >
        </x-forms.input.read-only>

        <x-forms.input.read-only
            attribute="storeSlug"
            label="Loja"
            id="update-price-{{ $price->id }}-store"
            value="{{ $price->storeSlug }}"
        >
        </x-forms.input.read-only>

        <input type="submit"
               class="btn btn-dark d-block w-100 mx-auto m-2"
               value="Salvar" />
    </x-forms.form.put>
</div>
