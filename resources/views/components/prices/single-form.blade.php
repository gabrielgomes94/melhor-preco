<div>
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
    <div class="form-group">
        <form method="post" action="{{ route('prices.calculate_single') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="codigo">Código SKU</label>
                <input type="text" class="form-control input-sku" id="name" placeholder="Código SKU" name="sku">
            </div>

            <div class="form-group">
                <label for="price">Preço de Compra(valor unitário do produto, sem incluir impostos ou frete, em R$)</label>
                <input type="text" class="form-control input-price" id="price" placeholder="Preço de Compra" name="price" value="{{ $purchasePrice ?? '' }}">
            </div>

            <div class="form-group">
                <label for="commission">Comissão (%)</label>
                <input type="text" class="form-control input-commission" id="commission" placeholder="Comissão" name="commission" value=12.8>
            </div>

            <div class="form-group">
                <label for="profit-margin">Margem de lucro desejada (%)</label>
                <input type="number" class="form-control input-profit-margin" id="profit-margin" placeholder="Margem de Lucro" name="profit-margin" value="25">
            </div>

            <div class="form-group">
                <label for="tax-ipi">IPI (%)</label>
                <input type="number" class="form-control input-tax-ipi" id="tax-ipi" placeholder="Comissão" name="tax-ipi" value="4">
            </div>

            <div class="form-group">
                <label for="tax-icms">Diferença de Alíquota de ICMS (%)</label>
                <input type="number" class="form-control input-tax-icms" id="tax-icms" placeholder="Comissão" name="tax-icms" value="6">
            </div>

            <div class="form-group">
                <label for="tax-simples-nacional">Frete (em R$)</label>
                <input type="text" class="form-control input-tax-simples-nacional" id="tax-simples-nacional" placeholder="Frete" name="freight">
            </div>

            <input type="submit"  class="btn btn-dark d-block w-75 mx-auto m-2" value="Calcular" />
        </form>
    </div>
</div>
