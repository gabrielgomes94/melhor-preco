<x-layout>
    <div class="container">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Precificação') }}
            </h2>
        </x-slot>

        <div class="row">
            <div class="col">
                <x-pricing.products.list-table :pricing="$pricing" />
            </div>
        </div>

        <x-utils.navigation-button
            :route="route('pricing.create')"
            label="Exportar"
        />
    </div>
</x-layout>
<?php
