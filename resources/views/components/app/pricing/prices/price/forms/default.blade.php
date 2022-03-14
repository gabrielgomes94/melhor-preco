<div class="form-group">
    <x-template.forms.put
        action="{{ route('pricing.products.prices.update', [$productId, $price['id']]) }}"
    >
        <x-template.input.hidden
            attribute="storeSlug"
            label="Loja"
            componentId="update-price-{{ $price['id'] }}-store"
            value="{{ $price['storeSlug'] }}"
        >
        </x-template.input.hidden>

        <x-bootstrap.forms.input.hidden
            id="update-price-{{ $price['id'] }}-value"
            name="value"
            :value="$price['mainPrice']['value']"
        >

        </x-bootstrap.forms.input.hidden>

        <div class="d-flex justify-content-center mt-3 mb-2">
            <x-template.buttons.submit label="Salvar" />
        </div>
    </x-template.forms.put>
</div>
