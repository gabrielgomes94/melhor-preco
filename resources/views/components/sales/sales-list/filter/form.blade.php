<div class="d-flex justify-content-end">
    <x-template.forms.get
        action="{{ route('sales.list') }}"
        formId="filter-sales-list"
    >
        <div class="d-inline-flex">
            <x-sales.sales-list.filter.inputs />
            <x-sales.sales-list.filter.submit />
        </div>
    </x-template.forms.get>
</div>
