let i = 0
let input = document.querySelector('.input-sku');
let inputName = document.querySelector('.input-name');
let inputStockAmount = document.querySelector('.input-stock-amount');
let buttonAddProduct = document.querySelector('#button-add-product')
let table = document.querySelector('#input-table-body')
let errorBox = document.querySelector('#error-box')

input.addEventListener('change', function () {
    // var base = window.location.href
    var base = 'http://barrigudinha.test:8000/'
    const api_url = base + "api/product/" + this.value + "/stock"

    // Defining async function
    async function getapi(url) {
        inputName.value = ''
        inputStockAmount.value = ''
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
    nameCell.innerText = inputName.value
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
