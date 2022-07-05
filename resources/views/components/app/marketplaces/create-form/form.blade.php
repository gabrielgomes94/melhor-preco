<x-bootstrap.forms.form.post action="{{ route('marketplaces.store') }}">
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
    </div>

    <div class="mt-2">
        <h5>Status</h5>

        <x-bootstrap.forms.input.toggle-switch
            id="status-check"
            name="status"
            value="active"
            active="true"
            previousLabel="Inativo"
            nextLabel="Ativo"
        />
    </div>

    <div class="d-flex justify-content-center mt-2">
        <x-bootstrap.buttons.submit label="Salvar" />
    </div>
</x-bootstrap.forms.form.post>
