<div>
    <div class="form-group">
        <h3>Nome do Produto</h3>

        <form method="post" action="{{ route('prices.calculate_single') }}" enctype="multipart/form-data">
            @csrf

            <x-forms.input.read-only
                attribute="name"
                label="Nome do Produto"
                value="{{ $productInfo->name }}"
            >
            </x-forms.input.read-only>

            <x-forms.input.money
                attribute="purchasePrice"
                label="Preço de Compra"
                value="{{ $productInfo->purchasePrice }}"
            >
            </x-forms.input.money>

            <x-forms.input.percentage
                attribute="taxIPI"
                label="Imposto IPI"
                value="{{ $productInfo->taxIPI }}"
            >
            </x-forms.input.percentage>

            <x-forms.input.percentage
                attribute="taxICMS"
                label="Imposto ICMS"
                value="{{ $productInfo->taxICMS }}"
            >
            </x-forms.input.percentage>

            <x-forms.input.percentage
                attribute="taxSimplesNacional"
                label="Imposto Simples Nacional"
                value="{{ $productInfo->taxSimplesNacional }}"
            >
            </x-forms.input.percentage>

            <x-forms.input.money
                attribute="additionalCosts"
                label="Custos Adicionais"
                value="{{ $productInfo->additionalCosts }}"
            >
            </x-forms.input.money>

            <input type="submit"
                   class="btn btn-dark d-block w-100 mx-auto m-2"
                   value="Atualizar" />
        </form>
    </div>

</div>
