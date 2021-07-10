<x-forms.form.put :action="route('products.costs.update', $product->sku())">
    <tr>
        <td>
            {{ $product->sku() }}
            <x-forms.input.hidden
                attribute="sku"
                componentId="sku-{{ $product->sku() }}"
                value="{{ $product->sku() }}"
            >
            </x-forms.input.hidden>
        </td>
        <td>{{ $product->name() }}</td>
        <td>
            <x-forms.input.money
                attribute="purchasePrice"
                componentId="purchasePrice-{{ $product->sku() }}"
                value="{{ $product->costs()->purchasePrice() }}"
            >
            </x-forms.input.money>
        </td>
        <td>
            <x-forms.input.percentage
                attribute="taxICMS"
                componentId="taxICMS-{{ $product->sku() }}"
                value="{{ $product->costs()->taxICMS() }}"
            >
            </x-forms.input.percentage>
        </td>
        <td>
            <x-forms.input.money
                attribute="additionalCosts"
                componentId="additionalCosts-{{ $product->sku() }}"
                value="{{ $product->costs()->additionalCosts() }}"
            >
            </x-forms.input.money>
        </td>
        <td>
            <x-forms.submit label="Atualizar"/>
        </td>
    </tr>
</x-forms.form.put>
