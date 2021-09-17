@foreach ($variations as $variation)
    <x-forms.form.put :action="route('products.costs.update', $variation->sku())">
        <tr class="d-flex">
            <td class="col-1">
                <x-forms.input.hidden
                    attribute="sku"
                    componentId="sku-{{ $variation->sku() }}"
                    value="{{ $variation->sku() }}"
                >
                </x-forms.input.hidden>
            </td>

            <td class="col-4"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="{{ $variation->name() }}"
            >
                {{$variation->sku()}} - {{ $variation->name() }}
            </td>

            <td class="col-2">
                <x-forms.input.money
                    attribute="purchasePrice"
                    componentId="purchasePrice-{{ $variation->sku() }}"
                    value="{{ $variation->costs()->purchasePrice() }}"
                >
                </x-forms.input.money>
            </td>

            <td class="col-2">
                <x-forms.input.percentage
                    attribute="taxICMS"
                    componentId="taxICMS-{{ $variation->sku() }}"
                    value="{{ $variation->costs()->taxICMS() }}"
                >
                </x-forms.input.percentage>
            </td>
            <td class="col-2">
                <x-forms.input.money
                    attribute="additionalCosts"
                    componentId="additionalCosts-{{ $variation->sku() }}"
                    value="{{ $variation->costs()->additionalCosts() }}"
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
