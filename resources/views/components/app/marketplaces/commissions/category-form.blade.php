<x-bootstrap.forms.form.post action="{{ route('marketplaces.doSetCommissionByCategory', $marketplaceSlug) }}">
    <x-app.marketplaces.commissions.category-table.table :categories="$categories" />

    <div class="d-flex justify-content-center mt-3">
        <x-bootstrap.forms.input.submit label="Salvar" />
    </div>
</x-bootstrap.forms.form.post>
