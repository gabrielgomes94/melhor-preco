<x-layout>
    <x-app.pricing.navigation :activeNavCosts="true"/>

    <div class="row">
        <x-bootstrap.alert-messages.alert-messages />
    </div>

    <div class="row">
        <div class="col-12">
            <x-app.costs.product-costs.list.card.card
                :paginator="$paginator"
                :products="$products"
                :filter="$filter"
            />
        </div>
    </div>
</x-layout>
