<x-layout>
    <x-slot name="navbar">
        <x-app.pricing.price-list.navbar :selected="$store->slug()"/>
    </x-slot>

    <x-slot name="breadcrumb">
        <x-bootstrap.breadcrumb.breadcrumb.breadcrumb :breadcrumb="$breadcrumb"/>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <x-bootstrap.card.basic.card>
                <x-bootstrap.card.basic.card-body>
                    <div class="d-flex justify-content-between">
                        <x-app.pricing.price-log.table :products="$products"/>
                    </div>

                    <x-bootstrap.paginator.paginator-links :paginator="$paginator"/>
                </x-bootstrap.card.basic.card-body>
            </x-bootstrap.card.basic.card>
        </div>
    </div>
</x-layout>
