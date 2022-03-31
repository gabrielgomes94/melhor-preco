<x-layout>
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
            <x-app.products.reports.card.card header="Informações Gerais de Produtos">
                <x-app.products.reports.informations.table :data="$data" />
            </x-app.products.reports.card.card>
        </div>
    </div>
</x-layout>
