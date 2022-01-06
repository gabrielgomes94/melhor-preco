<x-layout>
    <x-slot name="navbar">
        <x-app.pricing.price-list.navbar :selected="$store->slug()"/>
    </x-slot>

    <x-slot name="breadcrumb">
        <x-template.breadcrumb.breadcrumb.breadcrumb :breadcrumb="$breadcrumb"/>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <x-template.card.card>
                <div class="d-flex justify-content-between">
                    <x-app.pricing.price-log.table :products="$products"/>
                </div>

                <x-template.paginator.paginator-links :paginator="$paginator"/>
            </x-template.card.card>
        </div>
    </div>
</x-layout>
