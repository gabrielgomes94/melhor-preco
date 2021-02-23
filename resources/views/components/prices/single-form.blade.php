<div>
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
    <div class="form-group">
        <form method="post" action="{{ route('prices.calculate_single') }}" enctype="multipart/form-data">
            @csrf

            <x-forms.input
                name="sku"
                label="Código SKU"
                id="sku"
                class="input-sku"
                type="text"
                placeholder="Código SKU"
                value="{{ $priceParams['sku'] ?? '' }}">
            </x-forms.input>

            <x-forms.input
                name="price"
                label="Preço de Compra(valor unitário do produto, sem incluir impostos ou frete, em R$)"
                id="price"
                class="input-price"
                type="text"
                placeholder="Preço de Compra"
                value="{{ $purchasePrice ?? '' }}">
            </x-forms.input>

            <x-forms.input
                name="commission"
                label="Comissão (%)"
                id="commission"
                class="input-commission"
                type="text"
                placeholder="Comissão"
                value="{{ $priceParams['commission'] ?? '' }}">
            </x-forms.input>

            <x-forms.input
                name="profit-margin"
                label="Margem de lucro desejada (%)"
                id="profit-margin"
                class="input-profit-margin"
                type="number"
                placeholder="Margem de Lucro"
                value="{{ $priceParams['profit-margin'] ?? '' }}">
            </x-forms.input>

            <x-forms.input
                name="tax-icms"
                label="IPI (%)"
                id="tax-ipi"
                class="input-tax-ipi"
                type="number"
                placeholder="IPI"
                value="{{ $priceParams['tax-ipi'] ?? '' }}">
            </x-forms.input>

            <x-forms.input
                name="tax-icms"
                label="Diferença de Alíquota de ICMS (%)"
                id="tax-icms"
                class="input-tax-icms"
                type="number"
                placeholder="Diferença de Alíquota"
                value="{{ $priceParams['tax-icms'] ?? '' }}">
            </x-forms.input>

            <x-forms.input
                name="freight"
                label="Frete (em R$)"
                id="tax-simples-nacional"
                class="input-tax-simples-nacional"
                type="text"
                placeholder="Frete"
                value="{{ $priceParams['freight'] ?? '' }}">
            </x-forms.input>

            <input type="submit"  class="btn btn-dark d-block w-75 mx-auto m-2" value="Calcular" />
        </form>
    </div>
</div>
