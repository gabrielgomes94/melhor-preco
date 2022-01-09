<x-layout>
    <x-slot name="navbar">
        <x-app.costs.navbar />
    </x-slot>

    <div class="row">
        <x-template.alert-messages.alert-messages />
    </div>

    <div class="row m-4">
        <div class="col-12">
            <x-app.costs.product-costs.card :paginator="$paginator" :products="$products" :sku="$sku" />
        </div>
    </div>
</x-layout>
