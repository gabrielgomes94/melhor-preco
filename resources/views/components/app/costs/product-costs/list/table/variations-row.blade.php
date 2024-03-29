@foreach ($variations as $variation)
    <x-bootstrap.forms.form.put :action="route('costs.product.update', $variation->getSku())">
        <tr>
            <td colspan="1">
                <x-bootstrap.forms.input.hidden
                    attribute="sku"
                    componentId="sku-{{ $variation->getSku() }}"
                    value="{{ $variation->getSku() }}"
                >
                </x-bootstrap.forms.input.hidden>
            </td>

            <td colspan="4"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="{{ $variation->getName() }}"
            >
                {{$variation->getSku()}} - {{ $variation->getName() }}
            </td>

            <td colspan="2">
                <x-bootstrap.forms.input.money
                    attribute="purchasePrice"
                    componentId="purchasePrice-{{ $variation->getSku() }}"
                    value="{{ $variation->getCosts()->purchasePrice() }}"
                >
                </x-bootstrap.forms.input.money>
            </td>

            <td colspan="2">
                <x-bootstrap.forms.input.money
                    attribute="additionalCosts"
                    componentId="additionalCosts-{{ $variation->getSku() }}"
                    value="{{ $variation->getCosts()->additionalCosts() }}"
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
@endforeach
