<div>
    <div class="form-group">
        <h3>Nome do Produto</h3>

        <form method="post" action="{{ route('prices.calculate_single') }}" enctype="multipart/form-data">
            @csrf

            <x-forms.input
                name="name"
                label="Nome do Produto"
                id="sku"
                class="input-sku"
                type="text"
                placeholder="Código SKU"
                value="{{ $priceParams['sku'] ?? '' }}"
                disabled="true"
            ></x-forms.input>

            <x-forms.input
                name="name"
                label="Preço de Compra"
                id="sku"
                class="input-sku"
                type="text"
                placeholder="Código SKU"
                value="{{ $priceParams['sku'] ?? '' }}"
                disabled="true"
            ></x-forms.input>

            <x-forms.input
                name="tax_ipi"
                label="IPI"
                id="sku"
                class="input-tax-ipi"
                type="text"
                placeholder="Imposto IPI"
                value="{{ $priceParams['sku'] ?? '' }}"
            ></x-forms.input>

            <x-forms.input
                name="tax_icms"
                label="ICMS"
                id="tax_icms"
                class="input-tax-icms"
                type="text"
                placeholder="Imposto ICMS"
                value="{{ $priceParams['sku'] ?? '' }}"
            ></x-forms.input>

            <x-forms.input
                name="tax_simples_nacional"
                label="Imposto Simples Nacional"
                id="tax_simples_nacional"
                class="input-tax-simples-nacional"
                type="text"
                placeholder="Imposto Simples Nacional"
                value="{{ $priceParams['sku'] ?? '' }}"
            ></x-forms.input>

            <x-forms.input
                name="additional_costs"
                label="Custos Adicionais"
                id="additional-costs"
                class="input-additional-costs"
                type="text"
                placeholder="Custos Adicionais"
                value="{{ $priceParams['sku'] ?? '' }}"
            ></x-forms.input>


            <input type="submit"
                   class="btn btn-dark d-block w-100 mx-auto m-2"
                   value="Atualizar" />
        </form>
    </div>

</div>
