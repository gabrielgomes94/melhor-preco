let calculator_form = function() {
    var forms = document.querySelectorAll('.price-calculator-form')

    var tableAttributes = {
        costs: [
            'commission',
            'purchasePrice',
            'freight',
            'taxSimplesNacional',
            'differenceICMS',
        ],
        profit: [
            'profit',
            'margin',
        ],
        desiredPrice: 'price'
    }

    function getFormData(form) {
        var id = form.dataset.priceId


        let calculatorParams = {
            commission: form.querySelector('#commission-' + id).value,
            desiredPrice: form.querySelector('#desiredPrice-' + id).value,
            discount: form.querySelector('#discount-' + id).value,
            freeFreight: form.querySelector('#freeFreight-' + id).checked ? '1' : '0',
            product: form.querySelector('#product-' + id).value,
            store: form.querySelector('#store-' + id).value
        }

        let formData = new FormData()
        formData.append('commission', calculatorParams.commission)
        formData.append('desiredPrice', calculatorParams.desiredPrice)
        formData.append('discount', calculatorParams.discount)
        formData.append('freeFreight', calculatorParams.freeFreight)
        formData.append('product', calculatorParams.product)
        formData.append('store', calculatorParams.store)

        return formData
    }

    forms.forEach(function(form){
        var id = form.dataset.priceId
        let pricePreffix = 'update-price'

        let calculator = {
            price: getInput(id, 'value', pricePreffix),
            profit: getInput(id, 'profit', pricePreffix),
            margin: getInput(id, 'margin', pricePreffix),
            commission: getInput(id, 'commission', pricePreffix),
            taxSimplesNacional: getInput(id, 'taxSimplesNacional', pricePreffix),
            freight: getInput(id, 'freight', pricePreffix),
            differenceICMS: getInput(id, 'differenceICMS', pricePreffix),
            purchasePrice: getInput(id, 'purchasePrice', pricePreffix)
        }

        function getInput (id, inputName, preffix) {
            return document.querySelector('#' + preffix + '-' + id + '-' + inputName)
        }

        function setColor(object, input, color) {
            var backgroundColor =  '#e9ecef'

            switch(color) {
                case 'red':
                    backgroundColor = '#dc3545'
                    break
                case 'green':
                    backgroundColor = '#198754';
                    break
            }

            object[input].style.color = backgroundColor
        }

        function setValue(object, input, value) {
            object[input].innerText = value
        }

        function setData(object, data) {
            setValue(object, tableAttributes.desiredPrice, data.suggestedPrice)

            tableAttributes.costs.forEach(function (attribute) {
                setValue(object, attribute, data[attribute])
                setColor(object, attribute, 'red')
            })

            tableAttributes.profit.forEach(function (attribute) {
                setValue(object, attribute, data[attribute])

                $color = data[attribute] > 0 ? 'green' : 'red'
                setColor(object, attribute, $color)
            })
        }

        form.addEventListener('submit', (event) => {
            event.preventDefault()
            let formData = getFormData(form)
            console.log(formData)

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .catch(error => console.error('Error:', error))
                .then(function(data) {
                    console.log(data)
                    setData(calculator, data.price)
                })
        })
    })
}

calculator_form()
