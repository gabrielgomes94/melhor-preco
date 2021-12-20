<div class="d-flex justify-content-end">
    <x-template.forms.get
        action="{{ $route }}"
        formId="filter-sales-list"
    >
        <div class="d-inline-flex">
            <x-app.sales.sales-list.filter.inputs />
            <x-app.sales.sales-list.filter.submit />
        </div>
    </x-template.forms.get>
</div>
