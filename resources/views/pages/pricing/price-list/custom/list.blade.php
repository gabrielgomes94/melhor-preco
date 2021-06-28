<x-layout>
    <div class="container">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Precificação') }}
            </h2>
        </x-slot>

        <div class="row">
            <div class="col d-inline-flex m-2">
                <x-utils.navigation-button
                    :route="route('pricing.create')"
                    label="Novo"
                />
            </div>
        </div>
        <div class="row">
            <div class="col">
                <x-pricing.price-list.custom-list-table :priceLists="$pricingList"/>
            </div>
        </div>
    </div>
</x-layout>
