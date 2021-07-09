<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Relatório de Produtos que Excedem Dimensões') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row mt-4">
            <div class="col-sm-12">
                <table class="table w-100">
                    <thead>
                    <tr>
                        <th scope="col" class="w-10">SKU</th>
                        <th scope="col" class="w-10">Nome</th>
                        <th scope="col" class="w-10">Preço de Custo (R$)</th>
                        <th scope="col" class="w-10">Alíquota de ICMS (%)</th>
                        <th scope="col" class="w-10">Custos Adicionais (R$)</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <x-forms.form.post :action="route('products.costs.update', $product->sku())">
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
                        </x-forms.form.post>
                    @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {!! $paginator->links() !!}
                </div>
            </div>
        </div>
    </div>
</x-layout>
