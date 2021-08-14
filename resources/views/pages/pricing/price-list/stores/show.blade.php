<x-layout>
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10">
                <x-utils.breadcrumb :breadcrumb="$breadcrumb"/>

                <div class="d-flex justify-content-between">
                    <h2>Precificação {{ $store->name() }}</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="d-flex flex-column justify-content-around">
                    <div class="d-flex justify-content-end m-2">
                        <x-pricing.products.single-store.filter-by-profit
                            :store="$store"
                            :minimumProfit="$minimumProfit"
                            :maximumProfit="$maximumProfit"
                            :sku="$sku"
                        />
                    </div>

                    <div class="d-flex justify-content-end m-2">
                        <x-pricing.products.single-store.filter-kits :store="$store" />
                    </div>

{{--                TODO:
                        - Filtrar apenas Kits
                        - Todos os produtos
--}}

                    <div class="d-flex justify-content-end m-2">
                        <x-pricing.products.single-store.export-button :store="$store" />
                    </div>
                </div>
            </div>

            <div class="col-md-10">
                <div class="d-flex">
                    <x-pricing.price-list.products.store-list.table :products="$products" :store="$store"/>
                </div>

                <x-utils.paginator-links :paginator="$paginator" />
            </div>
        </div>
    </div>
</x-layout>
