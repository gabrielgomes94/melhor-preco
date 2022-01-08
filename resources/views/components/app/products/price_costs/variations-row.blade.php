@foreach ($variations as $variation)
    <x-template.forms.put :action="route('costs.update', $variation->getSku())">
        <tr class="d-flex">
            <td class="col-1">
                <x-template.input.hidden
                    attribute="sku"
                    componentId="sku-{{ $variation->getSku() }}"
                    value="{{ $variation->getSku() }}"
                >
                </x-template.input.hidden>
            </td>

            <td class="col-4"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="{{ $variation->getDetails()->getName() }}"
            >
                {{$variation->getSku()}} - {{ $variation->getDetails()->getName() }}
            </td>

            <td class="col-2">
                <x-template.input.money
                    attribute="purchasePrice"
                    componentId="purchasePrice-{{ $variation->getSku() }}"
                    value="{{ $variation->getCosts()->purchasePrice() }}"
                >
                </x-template.input.money>
            </td>

            <td class="col-2">
                <x-template.input.percentage
                    attribute="taxICMS"
                    componentId="taxICMS-{{ $variation->getSku() }}"
                    value="{{ $variation->getCosts()->taxICMS() }}"
                >
                </x-template.input.percentage>
            </td>
            <td class="col-2">
                <x-template.input.money
                    attribute="additionalCosts"
                    componentId="additionalCosts-{{ $variation->getSku() }}"
                    value="{{ $variation->getCosts()->additionalCosts() }}"
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
@endforeach
