<x-layout.container>
    <x-layout.row>
        <x-layout.column :size="6">
            <x-pricing.prices.calculator.forms.calculator :productId="$productId" :price="$price" />
        </x-layout.column>

        <x-layout.column :size="6">
            <x-pricing.prices.calculator.price.price :productId="$productId" :price="$price" />
        </x-layout.column>
    </x-layout.row>
</x-layout.container>