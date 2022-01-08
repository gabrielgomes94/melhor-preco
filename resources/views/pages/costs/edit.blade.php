<x-layout>
    <x-slot name="navbar">
        <x-app.costs.navbar />
    </x-slot>

    <div class="container">
        <div class="row">
            <x-template.alert-messages.alert-messages />
        </div>

        <div class="row my-3">
            <div class="col-md-12">
                <x-app.costs.product-costs.card :paginator="$paginator" :products="$products" :sku="$sku" />
            </div>
        </div>
    </div>
</x-layout>
