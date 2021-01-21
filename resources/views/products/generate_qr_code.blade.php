<body class="antialiased">
    <x-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('QR Codes') }}
            </h2>
        </x-slot>

        <div class="container">
            <div class="row mt-4">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <div class="error-container">
                        <div id="error-box" class="">
                            <p id="error-box-message" class="text-danger"></p>
                        </div>
                    </div>

                    <form>
                        <div class="">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="">
                                        <label for="sku" class="form-label">Sku</label>
                                        <input type="number" class="form-control input-sku" id="sku" aria-describedby="sku">
                                    </div>
                                </div>


                                <div class="col-sm">
                                    <div class="">
                                        <label for="stock-amount" class="form-label">Quantidade</label>
                                        <input type="number" class="form-control input-stock-amount" id="stock-amount" aria-describedby="stock-amount">
                                    </div>
                                </div>

                                <div class="col-sm">
                                    <button type="button" class="btn btn-primary" id="button-add-product">Adicionar</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm">
                                    <div class="">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control input-name" id="name" aria-describedby="name" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-2"></div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <form action="qr_codes/new" method="post">
                        @csrf
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Quantidade</th>
                            </tr>
                            </thead>
                            <tbody id="input-table-body">
                            </tbody>
                        </table>

                        <button type="submit" cl?
                </div>
                <div class="col-sm-2"></div>
            </div>
        </div>
    </x-layout>
</body>

<script type="text/javascript">
    let i = 0
    let input = document.querySelector('.input-sku');
    let inputName = document.querySelector('.input-name');
    let inputStockAmount = document.querySelector('.input-stock-amount');
    let buttonAddProduct = document.querySelector('#button-add-product')
    let table = document.querySelector('#input-table-body')
    let errorBox = document.querySelector('#error-box')

    input.addEventListener('change', function () {
        // var base = window.location.href
        base = 'http://barrigudinha.test:8000/'
        const api_url = base + "api/product/" + this.value + "/stock"

        // Defining async function
        async function getapi(url) {
            const response = await fetch(url)

            var data = await response.json()

            // console.log(data)
            if (data['errors']) {
                errorBox.innerHTML = data['errors']
                errorBox.classList.add("alert")
                errorBox.classList.add("alert-danger")

                return
            }

            if (response) {
                inputName.value = data['products'][0]['name']
                inputStockAmount.value = data['products'][0]['stock']
            }
        }

        getapi(api_url);
    });

    buttonAddProduct.addEventListener('click', function (){
        var row = document.createElement('tr')
        var skuCell = document.createElement('th')
        var nameCell = document.createElement('td')
        var stock = document.createElement('td')

        skuCell.innerHTML = "<input type='number' name='products[" + i + "][sku]' value=" + input.value + ">"
        nameCell.innerHTML = "<input type='text' name='products[" + i + "][name]' value=" + inputName.value + ">"
        stock.innerHTML = "<input type='number' name='products[" + i + "][stock]' value=" + inputStockAmount.value + ">"

        if (inputStockAmount.value)
        {
            row.append(skuCell)
            row.append(nameCell)
            row.append(stock)
            table.appendChild(row)

            i++
        } else {
            errorBox.innerText = 'Aconteceu algum problema'

            errorBox.classList.add("alert")
            errorBox.classList.add("alert-danger")
        }
    });
</script>
