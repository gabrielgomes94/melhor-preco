<x-template.forms.post action="{{ route('marketplaces.doSetCommission') }}">
    <div class="mt-2">
        <x-bootstrap.forms.input.text
            attribute="commission"
            id="commission-input"
            label="Comissão (%)"
            value=""
        />
    </div>

    <x-app.marketplaces.commissions.category-table.table :categories="$categories" />

    <div class="d-flex justify-content-center mt-3">
        <x-bootstrap.forms.input.submit label="Salvar" />
    </div>
</x-template.forms.post>
