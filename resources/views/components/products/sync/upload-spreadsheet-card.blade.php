<div class="d-flex flex-column h-100 justify-content-between">
    <h3 class="text-center">Atualizar ICMS por Planilha</h3>

        <form method="post" action="{{ route('products.doUpdateICMS') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="d-grid justify-content-center">
                <label for="file">Escolha o arquivo .xlsx ou .csv</label><br>
                <input name="file[]" type="file" class="input-file form-control" multiple />
                <div class="preview-image d-flex" ></div>
            </div>

            <div class="d-flex justify-content-center">
                <input type="submit" class="btn btn-primary d-block m-2" value="Enviar" />
            </div>
        </form>
</div>
