<div class="form-group">
    <x-bootstrap.forms.form.put
        action="{{ route('pricing.products.prices.update', [$productId, $price['id']]) }}"
    >
        <x-bootstrap.forms.input.hidden
            attribute="value"
            componentId="update-price-{{ $price['id'] }}-value"
            value="{{ $price['mainPrice']['value'] }}"
        >
        </x-bootstrap.forms.input.hidden>

{{--        <x-bootstrap.forms.input.hidden--}}
{{--            attribute="purchasePrice"--}}
{{--            label="Preço de Compra"--}}
{{--            componentId="update-price-{{ $price['id'] }}-purchasePrice"--}}
{{--            value=""--}}
{{--        >--}}
{{--        </x-bootstrap.forms.input.hidden>--}}

{{--        <x-bootstrap.forms.input.read-only--}}
{{--            attribute="commission"--}}
{{--            label="Comissão"--}}
{{--            componentId="update-price-{{ $price['id'] }}-commission"--}}
{{--            value=""--}}
{{--        >--}}
{{--        </x-bootstrap.forms.input.read-only>--}}

{{--        <x-bootstrap.forms.input.hidden--}}
{{--            attribute="commissionRate"--}}
{{--            label="Comissão"--}}
{{--            componentId="update-price-{{ $price['id'] }}-commissionRate"--}}
{{--            value="{{ $price['mainPrice']['commission'] }}"--}}
{{--        >--}}
{{--        </x-bootstrap.forms.input.hidden>--}}

{{--        <x-bootstrap.forms.input.read-only--}}
{{--            attribute="freight"--}}
{{--            label="Frete"--}}
{{--            componentId="update-price-{{ $price['id'] }}-freight"--}}
{{--            value=""--}}
{{--        >--}}
{{--        </x-bootstrap.forms.input.read-only>--}}

{{--        <x-bootstrap.forms.input.read-only--}}
{{--            attribute="simplesNacional"--}}
{{--            label="Simples Nacional"--}}
{{--            componentId="update-price-{{ $price['id'] }}-taxSimplesNacional"--}}
{{--            value=""--}}
{{--        >--}}
{{--        </x-bootstrap.forms.input.read-only>--}}

{{--        <x-bootstrap.forms.input.read-only--}}
{{--            attribute="differenceICMS"--}}
{{--            label="Diferença de ICMS"--}}
{{--            componentId="update-price-{{ $price['id'] }}-differenceICMS"--}}
{{--            value=""--}}
{{--        >--}}
{{--        </x-bootstrap.forms.input.read-only>--}}

{{--        <x-bootstrap.forms.input.read-only--}}
{{--            attribute="profit"--}}
{{--            label="Lucro"--}}
{{--            componentId="update-price-{{ $price['id'] }}-profit"--}}
{{--            value="{{ $price['mainPrice']['profit'] }}"--}}
{{--        >--}}
{{--        </x-bootstrap.forms.input.read-only>--}}

{{--        <x-bootstrap.forms.input.read-only--}}
{{--            attribute="margin"--}}
{{--            label="Margem"--}}
{{--            componentId="update-price-{{ $price['id'] }}-margin"--}}
{{--            value="{{ $price['mainPrice']['margin'] }}"--}}
{{--        >--}}
{{--        </x-bootstrap.forms.input.read-only>--}}

        <x-bootstrap.forms.input.hidden
            attribute="storeSlug"
            componentId="update-price-{{ $price['id'] }}-store"
            value="{{ $price['storeSlug'] }}"
        >
        </x-bootstrap.forms.input.hidden>

        <div class="d-flex justify-content-center mt-3 mb-2">
            <x-bootstrap.buttons.submit label="Salvar" />
        </div>
    </x-bootstrap.forms.form.put>
</div>
