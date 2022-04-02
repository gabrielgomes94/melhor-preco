<x-layout>
    <x-slot name="navbar">
        <x-app.products.navbar.navbar />
    </x-slot>

    <div class="row my-4">
        <div class="col-sm-12">
            <div class="error-container">
                <div id="error-box" class="">
                    <p id="error-box-message" class="text-danger"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-4">
        <div class="col-12 my-4">
            <x-app.products.reports.card.card
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
            <x-app.products.filters.product-informations-filter :filter="$filter" />
        </x-bootstrap.modals.modal>
    </x-slot>
</x-layout>