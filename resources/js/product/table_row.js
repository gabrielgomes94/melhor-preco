export function create() {
        var row = document.createElement('tr')
        var skuCell = document.createElement('th')
        var nameCell = document.createElement('td')
        var stock = document.createElement('td')

        return {
            row: row,
            cells: {
                sku: skuCell,
                name: nameCell,
                stock: stock
            }
        }
}

export function update(cells, generateQRCode){
        cells.name.innerText = generateQRCode.input.name.value
        cells.sku.innerHTML = "<input type='number' name='products[" + i + "][sku]' value=" + generateQRCode.input.sku.value + ">"
        cells.stock.innerHTML = "<input type='number' name='products[" + i + "][stock]' value=" + generateQRCode.input.stockAmount.value + ">"

        return cells
}
