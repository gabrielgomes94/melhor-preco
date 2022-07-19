<x-layout>
    <div class="row">
        <x-bootstrap.alert-messages.alert-messages />
    </div>

    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between mb-2">
                <x-app.pricing.dropdown.menu />
            </div>

            <x-app.costs.product-costs.list.card.card
                :paginator="$paginator"
                :products="$products"
                :filter="$filter"
            />
        </div>
    </div>
</x-layout>
