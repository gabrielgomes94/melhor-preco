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

    forms.forEach(function(form){
        let id = form.dataset.priceId

        let calculator = {
            price: getInput(id, 'value'),
            profit: getInput(id, 'profit'),
            margin: getInput(id, 'margin'),
            commission: getInput(id, 'commission'),
            taxSimplesNacional: getInput(id, 'taxSimplesNacional'),
            freight: getInput(id, 'freight'),
            differenceICMS: getInput(id, 'differenceICMS'),
            purchasePrice: getInput(id, 'purchasePrice')
        }

        function getInput (id, inputName) {
            return document.querySelector('#update-price-' + id + '-' + inputName)
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

        function setMoneyValue(object, input, value) {
            value = Intl.NumberFormat('pt-BR', {
                style: "currency",
                currency: "BRL",
            }).format(value)

            object[input].innerText = value
        }

        function setPercentageValue(object, input, value) {
            value = Intl.NumberFormat('pt-BR').format(value) + '%'

            object[input].innerText = value
        }

        function setTableData(object, data) {
            setMoneyValue(object, tableAttributes.desiredPrice, data.suggestedPrice)

            tableAttributes.costs.forEach(function (attribute) {
                setMoneyValue(object, attribute, data[attribute])
                setColor(object, attribute, 'red')
            })

            setMoneyValue(object, 'profit', data['profit'])
            setColor(object, 'profit', getColor(data['profit']))

            setPercentageValue(object, 'margin', data['margin'])
            setColor(object, 'margin', getColor(data['margin']))
        }

        function getColor(value)
        {
            return value > 0 ? 'green' : 'red'
        }

        function setPriceInput(data, id)
        {
            inputElement = getInput(id, 'value')
            inputElement.value = data.suggestedPrice
        }

        function setPriceValue(data, id)
        {
            setTableData(calculator, data)
            setPriceInput(data, id)
        }

        function setupCalculatorForm() {
            var id = form.dataset.priceId
            console.log(id)

            function getFormData(form) {
                console.log(form)
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

            function calculatePrice() {
                let formData = getFormData(form)

                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .catch(error => console.error('Error:', error))
                    .then(function (data) {
                        setPriceValue(data.price, id)
                    })
            }

            document.addEventListener('DOMContentLoaded', (event) => {
                calculatePrice()
            })

            form.addEventListener('submit', (event) => {
                event.preventDefault()
                calculatePrice()
            })
        }

        setupCalculatorForm()
    })
}

calculator_form()
