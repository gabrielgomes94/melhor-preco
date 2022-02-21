<x-template.forms.post action="{{ route('marketplaces.store') }}">
    <div class="mt-1">
        <x-bootstrap.forms.input.text
            attribute="erpId"
            id="erpId-input"
            label="ID do Marketplace no Bling"
            value=""
        />
    </div>

    <div class="mt-1">
        <x-bootstrap.forms.input.text
            attribute="name"
            id="name-input"
            label="Nome do marketplace"
            value=""
        />
    </div>

    <div class="mt-2">
        <h5>Tipo de Comissão</h5>
        <x-bootstrap.forms.check.radio
            id="commissionType-unique-radio"
            label="Comissão única"
            name="commissionType"
            value="uniqueCommission"
        />

        <x-bootstrap.forms.check.radio
            id="commissionType-category-radio"
            label="Por Categoria"
            name="commissionType"
            value="categoryCommission"
        />

        <x-bootstrap.forms.check.radio
            id="commissionType-sku-radio"
            label="Por SKUs"
            name="commissionType"
            value="skuCommission"
        />
    </div>

    <div class="d-flex justify-content-center mt-2">
        <x-template.buttons.submit label="Salvar" />
    </div>
</x-template.forms.post>
