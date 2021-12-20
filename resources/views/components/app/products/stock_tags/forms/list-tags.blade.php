<form>
    <div class="">
        <div class="row">
            <div class="col-5">
                <div class="">
                    <label for="sku" class="form-label">Sku</label>
                    <input type="number" class="form-control input-sku" id="sku" aria-describedby="sku">
                </div>
            </div>


            <div class="col-5">
                <div class="">
                    <label for="stock-amount" class="form-label">Quantidade</label>
                    <input type="number" class="form-control input-stock-amount" id="stock-amount" aria-describedby="stock-amount">
                </div>
            </div>

            <div class="col-2">
                <div class="d-flex flex-column justify-content-center my-4">
                    <button type="button" class="btn btn-primary h-100" id="button-add-product">Adicionar</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control input-name" id="name" aria-describedby="name" readonly>
            </div>
        </div>
    </div>
</form>
