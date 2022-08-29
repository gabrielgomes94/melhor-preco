<x-layout>
    <x-app.products.navigation :activeNavProducts="true" />

    <div class="row my-2">
        <div class="col-sm-12">
            <div class="error-container">
                <div id="error-box" class="">
                    <p id="error-box-message" class="text-danger"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-12">
            <x-app.products.reports.informations.card
                header="Informações Gerais de Produtos"
                :data="$data"
                :filter="$filter"
                :paginator="$paginator"
            />
        </div>
    </div>

    <x-slot name="modals">
        <x-bootstrap.modals.modal
            id="filterModal"
            title="Filtrar produtos"
            actionLabel="Filtrar"
            formId="filter-products-form"
        >
            <x-app.products.reports.informations.filter :filter="$filter" />
        </x-bootstrap.modals.modal>
    </x-slot>
</x-layout>
