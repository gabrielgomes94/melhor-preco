<div class="d-flex justify-content-end">
    <x-template.forms.get
        action="{{ route('sales.list') }}"
        formId="filter-sales-list"
    >
        <div class="d-inline-flex">
            <x-sales.date-picker
                label="Data de Início"
                id="beginDate"
                inputName="beginDate"
                formId="filter-sales-list"></x-sales.date-picker>

            <span class="mx-2"></span>

            <x-sales.date-picker
                label="Data de Fim"
                id="endDate"
                inputName="endDate"
                formId="filter-sales-list"></x-sales.date-picker>
        </div>

        <div class="d-flex mx-2">
            <x-sales.sales-list.filter />
        </div>
    </x-template.forms.get>
</div>
