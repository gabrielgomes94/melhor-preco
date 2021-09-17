<x-forms.form.put :action="route('products.costs.update', $product->sku())">
    <tr class="d-flex">
        <td class="col-1">
            {{ $product->sku() }}
            <x-forms.input.hidden
                attribute="sku"
                componentId="sku-{{ $product->sku() }}"
                value="{{ $product->sku() }}"
            >
            </x-forms.input.hidden>
        </td>

        <td class="col-4"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            title="{{ $product->name() }}"
        >
            {{ $product->name() }}
        </td>

        <td class="col-2">
            <x-forms.input.money
                attribute="purchasePrice"
                componentId="purchasePrice-{{ $product->sku() }}"
                value="{{ $product->costs()->purchasePrice() }}"
            >
            </x-forms.input.money>
        </td>

        <td class="col-2">
            <x-forms.input.percentage
                attribute="taxICMS"
                componentId="taxICMS-{{ $product->sku() }}"
                value="{{ $product->costs()->taxICMS() }}"
            >
            </x-forms.input.percentage>
        </td>

        <td class="col-2">
            <x-forms.input.money
                attribute="additionalCosts"
                componentId="additionalCosts-{{ $product->sku() }}"
                value="{{ $product->costs()->additionalCosts() }}"
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
