<x-layout>
    <div class="container">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Campanhas de Preço') }}
            </h2>
        </x-slot>


        <div class="row">
            <div class="col">
                <!-- utils/pageTitle -->
                <x-pricing.campaigns-table :campaigns="$campaigns"/>
            </div>
        </div>
    </div>
</x-layout>
