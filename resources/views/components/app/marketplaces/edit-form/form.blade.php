<x-bootstrap.forms.form.post action="{{ route('marketplaces.update', $marketplace['slug']) }}">
    <div class="mt-1">
        <x-bootstrap.forms.input.text
            attribute="erpId"
            id="erpId-input"
            label="ID do Marketplace no Bling"
            value="{{ $marketplace['erpId'] }}"
        />
    </div>

    <div class="mt-1">
        <x-bootstrap.forms.input.text
            attribute="name"
            id="name-input"
            label="Nome do marketplace"
            value="{{ $marketplace['name'] }}"
        />
    </div>

    <div class="mt-2">
        <h5>Tipo de Comissão</h5>

        <x-bootstrap.forms.check.radio
            id="commissionType-unique-radio"
            label="Comissão única"
            name="commissionType"
            value="uniqueCommission"
            active="{{ ($marketplace['commissionType'] === 'uniqueCommission') ? true : false }}"

        ></x-bootstrap.forms.check.radio>

        <x-bootstrap.forms.check.radio
            id="commissionType-category-radio"
            label="Por Categoria"
            name="commissionType"
            value="categoryCommission"
            active="{{ ($marketplace['commissionType'] === 'categoryCommission') ? true : false }}"
        ></x-bootstrap.forms.check.radio>
    </div>

    <div class="mt-2">
        <h5>Status</h5>

        <x-bootstrap.forms.input.toggle-switch
            id="status-check"
            name="status"
            value="active"
            active="{{ ($marketplace['isActive']) }}"
            previousLabel="Inativo"
            nextLabel="Ativo"
        />
    </div>

    <div class="d-flex justify-content-center mt-2">
        <x-bootstrap.buttons.submit label="Salvar" />
    </div>
</x-bootstrap.forms.form.post>
