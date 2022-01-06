<x-template.forms.put :action="route('products.costs.update', $product->getSku())">
    <tr class="d-flex">
        <td class="col-1">
            {{ $product->getSku() }}
            <x-template.input.hidden
                attribute="sku"
                componentId="sku-{{ $product->getSku() }}"
                value="{{ $product->getSku() }}"
            >
            </x-template.input.hidden>
        </td>

        <td class="col-4"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            title="{{ $product->getDetails()->getName() }}"
        >
            {{ $product->getDetails()->getName() }}
        </td>

        <td class="col-2">
            <x-template.input.money
                attribute="purchasePrice"
                componentId="purchasePrice-{{ $product->getSku() }}"
                value="{{ $product->getCosts()->purchasePrice() }}"
            >
            </x-template.input.money>
        </td>

        <td class="col-2">
            <x-template.input.percentage
                attribute="taxICMS"
                componentId="taxICMS-{{ $product->getSku() }}"
                value="{{ $product->getCosts()->taxICMS() }}"
            >
            </x-template.input.percentage>
        </td>

        <td class="col-2">
            <x-template.input.money
                attribute="additionalCosts"
                componentId="additionalCosts-{{ $product->getSku() }}"
                value="{{ $product->getCosts()->additionalCosts() }}"
            >
            </x-template.input.money>
        </td>

        <td class="col-1">
            <x-template.buttons.submit-with-icon>
                <x-app.base.icons.save />
            </x-template.buttons.submit-with-icon>
        </td>
    </tr>
</x-template.forms.put>
