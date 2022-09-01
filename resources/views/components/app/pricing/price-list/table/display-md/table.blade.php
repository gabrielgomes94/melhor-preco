<div class="d-md-flex d-lg-flex d-xl-none d-sm-none d-none">
    <table class="table table-hover w-100 px-2 price-list-table">
        <thead >
            <x-app.pricing.price-list.table.display-md.header />
        </thead>

        <tbody>
        @foreach($products as $product)
            <x-app.pricing.price-list.table.display-md.product-row
                :product="$product"
                :marketplaceSlug="$marketplace['slug']"
            />

            @if (!empty($product['variations']))
                @foreach($product['variations'] as $variation)
                    <x-app.pricing.price-list.table.display-md.variations-row
                        :product="$variation"
                        :marketplaceSlug="$marketplace['slug']"
                    />
                @endforeach
            @endif
        @endforeach
        </tbody>
    </table>

</div>
