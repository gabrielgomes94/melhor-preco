<x-layout.container>
    <x-layout.row>
        <x-layout.column :size="4"> </x-layout.column>
        <x-layout.column :size="4">
            <h5>Com subsídio de frete</h5>
        </x-layout.column>
        <x-layout.column :size="4">
            <h5>Sem subsídio de frete</h5>
        </x-layout.column>

    </x-layout.row>
    <x-layout.row>
        <x-layout.column :size="4">
            <x-pricing.prices.calculator.forms.calculator :productId="$productId" :price="$price" />
        </x-layout.column>

        <x-layout.column :size="4">
            <x-pricing.prices.calculator.price.price :productId="$productId" :price="$price" />
        </x-layout.column>

        <x-layout.column :size="4">
            <x-pricing.prices.calculator.price.without-freight-price
                :productId="$productId"
                :price="$price"
                :secondaryPrice="$secondaryPrice"/>
        </x-layout.column>
    </x-layout.row>
</x-layout.container>

