import * as errorBox from "./error_box";

let generateQRCodeForm = function() {
    let i = 0

    var generateQRCode = {
        input: {
            sku: document.querySelector('.input-sku'),
            name: document.querySelector('.input-name'),
            stockAmount: document.querySelector('.input-stock-amount')
        },
        button: {
            addProduct: document.querySelector('#button-add-product')
        },
        table: document.querySelector('#input-table-body'),
        errorBox: document.querySelector('#error-box')
    }

    let requestOptions = {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + tokenApiKey
        },
    }

    async function getProduct(url) {
        const response = await fetch(url, requestOptions)
            .then(function(data) {
                return data.json()
            })
            .then(function(data) {
                if (data.product) {
                    setProductSelector(data.product)
                }

                if (data.errors) {
                    // let errorBox = generateQRCode.errorBox
                    errorBox.show(data.errors[0].erro.msg, generateQRCode.errorBox)
                    // showErrorBox(data.errors[0].erro.msg)
                }
            })
            .catch(function(error) {
                addErrorMessage(error)
            })

        return response;
    }

    function cleanProductSelector() {
        setProductSelector()
    }

    function setProductSelector(data = null) {
        let name = data ? data.name : ''
        let stock = data ? data.stock : ''

        generateQRCode.input.name.value = name
        generateQRCode.input.stockAmount.value = stock
    }

    function createTableRow() {
        var row = document.createElement('tr')
        var skuCell = document.createElement('th')
        var nameCell = document.createElement('td')
        var stock = document.createElement('td')

        let tableRowStructure = {
            row: row,
            cells: {
                sku: skuCell,
                name: nameCell,
                stock: stock
            }
        }

        return tableRowStructure
    }

    function updateTableRow(cells){
        cells.name.innerText = generateQRCode.input.name.value
        cells.sku.innerHTML = "<input type='number' name='products[" + i + "][sku]' value=" + generateQRCode.input.sku.value + ">"
        cells.stock.innerHTML = "<input type='number' name='products[" + i + "][stock]' value=" + generateQRCode.input.stockAmount.value + ">"

        return cells
    }

    generateQRCode.button.addProduct.addEventListener('click', function (){
        console.log(errorBox)
        var tableRow = createTableRow()
        let cells = updateTableRow(tableRow.cells)
        let row = tableRow.row

        row.append(cells.sku)
        row.append(cells.name)
        row.append(cells.stock)
        generateQRCode.table.appendChild(row)
        i++
    });

    generateQRCode.input.sku.addEventListener('change', function () {
        // var base = window.location.href
        var base = 'http://barrigudinha.test:8000/'
        const api_url = base + "api/product/" + this.value

        cleanProductSelector()
        getProduct(api_url)
    });
}

generateQRCodeForm()
