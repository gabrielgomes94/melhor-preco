<x-bootstrap.forms.form.post
    action="{{ route('promotions.doCalculate') }}"
    id="calculate-promotions-form"
>
    <x-bootstrap.forms.input.text
        attribute="promotionName"
        id="calculate-promotions-form-promotion-name"
        label="Nome da promoção"
        value=""
    />

    <div class="row my-2">
        <div class="col-6">
            <x-bootstrap.forms.input.date-picker
                attribute="beginDate"
                id="calculate-promotions-form-begin-date"
                label="Data de Início"
            />
        </div>

        <div class="col-6">
            <x-bootstrap.forms.input.date-picker
                attribute="endDate"
                id="calculate-promotions-form-end-date"
                label="Data de Encerramento"
            />
        </div>
    </div>

    <div class="row my-2">
        <div class="col-4">
            <x-bootstrap.forms.input.text
                attribute="discount"
                id="calculate-promotions-form-discount"
                label="Desconto (%)"
                value=""
            />
        </div>

        <div class="col-4">
            <x-bootstrap.forms.input.text
                attribute="productsMaxLimit"
                id="calculate-promotions-form-products-max-limit"
                label="Limite máximo de produtos"
                value=""
            />
        </div>

        <div class="col-4">
            <x-bootstrap.forms.input.text
                attribute="marketplaceSubsidy"
                id="calculate-promotions-form-marketplace"
                label="Subsídio do Marketplace"
                value=""
            />
        </div>
    </div>

    <div class="d-flex justify-content-end mt-3 mb-2">
        <x-bootstrap.forms.input.submit label="Calcular" />
    </div>
</x-bootstrap.forms.form.post>
