<x-bootstrap.forms.form.put :action="route('costs.product.update', $product->getSku())">
    <tr>
        <td colspan="1">
            <x-bootstrap.links.link :route="route('costs.product.show', $product->getSku())">
                {{ $product->getSku() }}
            </x-bootstrap.links.link>

            <x-bootstrap.forms.input.hidden
                attribute="sku"
                componentId="sku-{{ $product->getSku() }}"
                value="{{ $product->getSku() }}"
            >
            </x-bootstrap.forms.input.hidden>
        </td>

        <td colspan="4"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            title="{{ $product->getDetails()->getName() }}"
        >
            {{ $product->getDetails()->getName() }}
        </td>

        <td colspan="2">
            <x-bootstrap.forms.input.money
                attribute="purchasePrice"
                componentId="purchasePrice-{{ $product->getSku() }}"
                value="{{ $product->getCosts()->purchasePrice() }}"
            >
            </x-bootstrap.forms.input.money>
        </td>

        <td colspan="2">
            <x-bootstrap.forms.input.money
                attribute="additionalCosts"
                componentId="additionalCosts-{{ $product->getSku() }}"
                value="{{ $product->getCosts()->additionalCosts() }}"
            >
            </x-bootstrap.forms.input.money>
        </td>

        <td colspan="1">
            <x-bootstrap.buttons.submit-with-icon>
                <x-app.base.icons.save />
            </x-bootstrap.buttons.submit-with-icon>
        </td>
    </tr>
</x-bootstrap.forms.form.put>
