<div>
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->

    <div class="form-group">
        <form method="post" action="{{ route('prices.calculate_single') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group ">
                <label for="codigo">Código SKU</label>
                <input type="text" class="form-control input-sku" id="name" placeholder="Código SKU" name="sku">
            </div>

            <div class="form-group">
                <label for="price">Preço de Compra</label>
                <input type="text" class="form-control input-price" id="price" placeholder="Nome" name="price">
            </div>

            <input type="submit"  class="btn btn-dark d-block w-75 mx-auto m-2" value="Enviar" />
        </form>
    </div>
</div>
