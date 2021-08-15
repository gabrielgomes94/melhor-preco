<x-layout>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <x-utils.breadcrumb :breadcrumb="$breadcrumb"/>

                <div class="d-flex justify-content-between">
                    <h2>Histórico de Atualizações - {{ $store->name() }}</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <x-pricing.price-log.table :products="$products"/>
                </div>
            </div>
        </div>
    </div>
</x-layout>
