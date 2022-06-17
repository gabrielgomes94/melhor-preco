<x-layout>
    <x-slot name="navbar">
        <x-app.pricing.navbar />
    </x-slot>

    <div class="container">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Precificação') }}
            </h2>
        </x-slot>

        <x-app.pricing.price-list.table/>
    </div>
</x-layout>
