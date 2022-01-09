<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-6 mb-4">
            <x-app.dashboard.sync-card :data="$data" />
        </div>

        <div class="col-6 mb-4">
        </div>
    </div>
</x-layout>
