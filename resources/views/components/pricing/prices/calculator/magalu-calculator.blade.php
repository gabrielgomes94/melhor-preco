<x-layout.container>
    <x-layout.row>
        <x-layout.column :size="4">
            <x-pricing.prices.calculator.forms.calculator :pricingId="$pricingId" :productId="$productId" :price="$price" />
        </x-layout.column>

        <x-layout.column :size="4">
            <x-pricing.prices.calculator.price.price :pricingId="$pricingId" :productId="$productId" :price="$price" />
        </x-layout.column>

        <x-layout.column :size="4">
            <x-pricing.prices.calculator.price.magalu-discount-price :pricingId="$pricingId" :productId="$productId" :price="$price" />
        </x-layout.column>
    </x-layout.row>
</x-layout.container>
