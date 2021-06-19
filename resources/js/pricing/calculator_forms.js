let calculator_form = function() {
    var forms = document.querySelectorAll('.price-calculator-form')

    function getFormData(form) {
        var id = form.dataset.priceId

        let calculatorParams = {
            store: form.querySelector('#store-' + id).value,
            commission: form.querySelector('#commission-' + id).value,
            additionalCosts: form.querySelector('#additionalCosts-' + id).value,
            desiredPrice: form.querySelector('#desiredPrice-' + id).value,
            product: form.querySelector('#product-' + id).value
        }

        var formData = new FormData()

        formData.append('store', calculatorParams.store)
        formData.append('commission', calculatorParams.commission)
        formData.append('additionalCosts', calculatorParams.additionalCosts)
        formData.append('desiredPrice', calculatorParams.desiredPrice)
        formData.append('product', calculatorParams.product)

        return formData
    }

    forms.forEach(function(form){
        var id = form.dataset.priceId
        let calculator = {
            inputs: {
                price: getInput(id, 'value'),
                profit: getInput(id, 'profit'),
                margin: getInput(id, 'margin'),
                commission: getInput(id, 'commission'),
                taxSimplesNacional: getInput(id, 'simplesNacional'),
                freight: getInput(id, 'freight'),
                differenceICMS: getInput(id, 'differenceICMS'),
                purchasePrice: getInput(id, 'purchasePrice'),
            }
        }

        function getInput (id, inputName) {
            return document.querySelector('#update-price-' + id + '-' + inputName)
        }

        function setColor(input, color) {
            var backgroundColor =  '#e9ecef'
            var textColor = '#222';

            switch(color) {
                case 'red':
                    backgroundColor = '#dc3545'
                    textColor = '#fff'
                    break
                case 'green':
                    backgroundColor = '#198754';
                    textColor = '#fff';
                    break
            }

            calculator.inputs[input].style.backgroundColor = backgroundColor
            calculator.inputs[input].style.color = textColor
        }

        function setValue(input, value) {
            calculator.inputs[input].value = value
        }

        form.addEventListener('submit', (event) => {
            event.preventDefault()
            var formData = getFormData(form)

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .catch(error => console.error('Error:', error))
                .then(function(data) {
                    setValue('price', data.price.suggestedPrice)
                    setValue('profit', data.price.profit)
                    setValue('commission', data.price.commission)
                    setValue('taxSimplesNacional', data.price.taxSimplesNacional)
                    setValue('freight', data.price.freight)
                    setValue('differenceICMS', data.price.differenceICMS)
                    setValue('purchasePrice', data.price.purchasePrice)
                    setValue('margin', data.price.margin)

                    setColor('commission', 'red')
                    setColor('taxSimplesNacional', 'red')
                    setColor('freight', 'red')
                    setColor('differenceICMS', 'red')
                    setColor('purchasePrice', 'red')

                    calculator.inputs.profit.value > 0
                        ? setColor('profit', 'green')
                        : setColor('profit', 'red')

                    calculator.inputs.margin.value > 0
                        ? setColor('margin', 'green')
                        : setColor('margin', 'red')
                })
        })
    })
}

calculator_form()
