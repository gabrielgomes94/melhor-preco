<x-template.forms.put :action="route('costs.product.update', $product->getSku())">
    <tr>
        <td colspan="1">
            <x-template.links.link :route="route('costs.product.show', $product->getSku())">
                {{ $product->getSku() }}
            </x-template.links.link>

            <x-template.input.hidden
                attribute="sku"
                componentId="sku-{{ $product->getSku() }}"
                value="{{ $product->getSku() }}"
            >
            </x-template.input.hidden>
        </td>

        <td colspan="4"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            title="{{ $product->getDetails()->getName() }}"
        >
            {{ $product->getDetails()->getName() }}
        </td>

        <td colspan="2">
            <x-template.input.money
                attribute="purchasePrice"
                componentId="purchasePrice-{{ $product->getSku() }}"
                value="{{ $product->getCosts()->purchasePrice() }}"
            >
            </x-template.input.money>
        </td>

        <td colspan="2">
            <x-template.input.money
                attribute="additionalCosts"
                componentId="additionalCosts-{{ $product->getSku() }}"
                value="{{ $product->getCosts()->additionalCosts() }}"
            >
            </x-template.input.money>
        </td>

        <td colspan="1">
            <x-template.buttons.submit-with-icon>
                <x-app.base.icons.save />
            </x-template.buttons.submit-with-icon>
        </td>
    </tr>
</x-template.forms.put>
