<x-bootstrap.forms.form.patch
    action="{{ route('promotions.update', $promotion['uuid']) }}"
    id="update-promotions-form"
>
    <x-bootstrap.forms.input.text
        attribute="promotionName"
        id="calculate-promotions-form-promotion-name"
        label="Nome da promoção"
        :value="$promotion['name']"
    />

    <div class="row my-2">
        <div class="col-6">
            <x-bootstrap.forms.input.date-picker
                attribute="beginDate"
                id="calculate-promotions-form-begin-date"
                label="Data de Início"
                value="{{ $promotion['beginDate'] }}"
            />
        </div>
dasd
        <div class="col-6">
            <x-bootstrap.forms.input.date-picker
                attribute="endDate"
                id="calculate-promotions-form-end-date"
                label="Data de Encerramento"
                value="{{ $promotion['endDate'] }}"
            />
        </div>
    </div>

    <div class="row my-2">
        <div class="col-4">
            <x-bootstrap.forms.input.text
                attribute="discount"
                id="calculate-promotions-form-discount"
                label="Desconto (%)"
                value="{{ $promotion['discount'] }}"
            />
        </div>

        <div class="col-4">
            <x-bootstrap.forms.input.text
                attribute="productsMaxLimit"
                id="calculate-promotions-form-products-max-limit"
                label="Limite máximo de produtos"
                value="{{ $promotion['maxProductsLimit'] }}"
            />
        </div>

        <div class="col-4">
            <x-bootstrap.forms.input.text
                attribute="marketplaceSubsidy"
                id="calculate-promotions-form-marketplace"
                label="Subsídio do Marketplace"
                value="{{ $promotion['marketplaceSubsidy'] }}"
            />
        </div>
    </div>

    <div class="d-flex justify-content-end mt-3 mb-2">
        <x-bootstrap.forms.input.submit label="Atualizar" />
    </div>
</x-bootstrap.forms.form.patch>
