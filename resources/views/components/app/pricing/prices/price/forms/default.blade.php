<div class="form-group">
    <x-bootstrap.forms.form.put
        action="{{ route('pricing.products.prices.update', [$productId, $price['priceId']]) }}"
    >
        <x-bootstrap.forms.input.hidden
            attribute="value"
            componentId="update-price-{{ $price['priceId'] }}-value"
            value="{{ $price['suggestedPrice'] }}"
        >
        </x-bootstrap.forms.input.hidden>

        <x-bootstrap.forms.input.hidden
            attribute="marketplaceSlug"
            componentId="update-price-{{ $price['priceId'] }}-marketplace-slug"
            value="{{ $price['marketplaceSlug'] }}"
        >
        </x-bootstrap.forms.input.hidden>

        <div class="d-flex justify-content-center mt-3 mb-2">
            <x-bootstrap.buttons.submit label="Salvar" />
        </div>
    </x-bootstrap.forms.form.put>
</div>
