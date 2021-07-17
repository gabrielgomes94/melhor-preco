<x-layout>
    <div class="container">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Precificação') }}
            </h2>
        </x-slot>

        <h3>{{ $priceList->name() }}</h3>

        <x-utils.breadcrumb :breadcrumb="$breadcrumb"/>
        <div class="row">
            <div class="col">
                <x-pricing.price-list.products.custom-list.table
                    :priceList="$priceList"
                    :stores="$stores"
                    :products="$products"
                />
            </div>
        </div>

        <x-utils.paginator-links :paginator="$paginator" />
    </div>
</x-layout>
