@foreach ($variations as $variation)
    <x-forms.form.put :action="route('products.costs.update', $variation->sku())">
        <tr>
            <td>
                <x-forms.input.hidden
                    attribute="sku"
                    componentId="sku-{{ $variation->sku() }}"
                    value="{{ $variation->sku() }}"
                >
                </x-forms.input.hidden>
            </td>
            <td>{{$variation->sku()}} - {{ $variation->name() }}</td>
            <td>
                <x-forms.input.money
                    attribute="purchasePrice"
                    componentId="purchasePrice-{{ $variation->sku() }}"
                    value="{{ $variation->costs()->purchasePrice() }}"
                >
                </x-forms.input.money>
            </td>
            <td>
                <x-forms.input.percentage
                    attribute="taxICMS"
                    componentId="taxICMS-{{ $variation->sku() }}"
                    value="{{ $variation->costs()->taxICMS() }}"
                >
                </x-forms.input.percentage>
            </td>
            <td>
                <x-forms.input.money
                    attribute="additionalCosts"
                    componentId="additionalCosts-{{ $variation->sku() }}"
                    value="{{ $variation->costs()->additionalCosts() }}"
                >
                </x-forms.input.money>
            </td>
            <td>
                <div class="form-group">
                    <x-forms.submit
                        label="Atualizar"
                        classComponents="form-control btn-dark-grey"
                    />
                </div>
            </td>
        </tr>
    </x-forms.form.put>
@endforeach
