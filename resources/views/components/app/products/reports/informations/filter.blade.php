<div class="d-flex flex-column justify-content-around">
    <x-bootstrap.forms.form.get
        :action="route('products.reports.informations')"
        formId="filter-products-form"
    >
        <div class="mb-4">
            <x-app.products.filters.category :filter="$filter" />
        </div>

        <div class="mb-4">
            <x-bootstrap.forms.input.text
                attribute="sku"
                id="sku-input"
                label="SKU"
                value="{{ $filter['sku'] }}"
            />
        </div>
    </x-bootstrap.forms.form.get>
</div>
