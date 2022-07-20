<div class="d-flex d-md-none">
    <table class="table table-hover w-100 px-2 price-list-table">
        <thead >
            <x-app.pricing.price-list.table.display-sm.header />
        </thead>

        <tbody>
        @foreach($products as $product)
            <x-app.pricing.price-list.table.display-sm.product-row
                :product="$product"
                :marketplaceSlug="$marketplace['slug']"
            />
        @endforeach
        </tbody>
    </table>
</div>
