<form method="post" action="{{ route('product.images.upload') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="sku">Código SKU</label>
        <input type="text" class="form-control input-sku" id="sku" placeholder="Código SKU" name="sku">
    </div>

    <div class="mb-3">
        <label for="name">Nome</label>
        <input type="text" class="form-control input-name" id="name" placeholder="Nome" name="name" readonly>
    </div>

    <div class="mb-3">
        <label for="brand">Marca</label>
        <input type="text" class="form-control input-brand" id="brand" placeholder="Marca" name="brand">
    </div>

    <div class="mb-3">
        <label for="imagens" class="form-label">Imagens</label>
        <input name="images[]" type="file" class="input-file form-control" id="imagens" multiple>
        <div class="preview-image d-flex flex-wrap m-2 p-2" ></div>
    </div>

    <input type="submit" class="btn btn-primary d-block mx-auto m-2 w-25" value="Enviar">
</form>
