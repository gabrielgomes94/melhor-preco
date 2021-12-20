@foreach ($variations as $variation)
    <x-forms.form.put :action="route('products.costs.update', $variation->getSku())">
        <tr class="d-flex">
            <td class="col-1">
                <x-forms.input.hidden
                    attribute="sku"
                    componentId="sku-{{ $variation->getSku() }}"
                    value="{{ $variation->getSku() }}"
                >
                </x-forms.input.hidden>
            </td>

            <td class="col-4"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="{{ $variation->getDetails()->getName() }}"
            >
                {{$variation->getSku()}} - {{ $variation->getDetails()->getName() }}
            </td>

            <td class="col-2">
                <x-forms.input.money
                    attribute="purchasePrice"
                    componentId="purchasePrice-{{ $variation->getSku() }}"
                    value="{{ $variation->getCosts()->purchasePrice() }}"
                >
                </x-forms.input.money>
            </td>

            <td class="col-2">
                <x-forms.input.percentage
                    attribute="taxICMS"
                    componentId="taxICMS-{{ $variation->getSku() }}"
                    value="{{ $variation->getCosts()->taxICMS() }}"
                >
                </x-forms.input.percentage>
            </td>
            <td class="col-2">
                <x-forms.input.money
                    attribute="additionalCosts"
                    componentId="additionalCosts-{{ $variation->getSku() }}"
                    value="{{ $variation->getCosts()->additionalCosts() }}"
                >
                </x-forms.input.money>
            </td>

            <td class="col-1">
                <x-template.buttons.submit-with-icon>
                    <x-layout.icons.save />
                </x-template.buttons.submit-with-icon>
            </td>
        </tr>
    </x-forms.form.put>
@endforeach
