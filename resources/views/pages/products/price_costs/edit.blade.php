<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Atualizar custos dos produtos') }}
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
                        <x-products.price_costs.product-row :product="$product" />

                        @if ($product->hasVariations())
                            <x-products.price_costs.variations-row :variations="$product->variations()->get()" />
                        @endif
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
