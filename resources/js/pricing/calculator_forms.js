let calculator_form = function() {
    var forms = document.querySelectorAll('.price-calculator-form')

    function getFormData(form) {
        var id = form.dataset.priceId

        let calculatorParams = {
            store: form.querySelector('#store-' + id).value,
            commission: form.querySelector('#commission-' + id).value,
            discount: form.querySelector('#discount-' + id).value,
            desiredPrice: form.querySelector('#desiredPrice-' + id).value,
            product: form.querySelector('#product-' + id).value
        }

        var formData = new FormData()

        formData.append('store', calculatorParams.store)
        formData.append('commission', calculatorParams.commission)
        formData.append('discount', calculatorParams.discount)
        formData.append('desiredPrice', calculatorParams.desiredPrice)
        formData.append('product', calculatorParams.product)

        return formData
    }

    forms.forEach(function(form){
        var id = form.dataset.priceId

        let pricePreffix = 'update-price'
        let discountedPricePreffix = 'discounted-price'

        let calculator = {
            price: {
                price: getInput(id, 'value', pricePreffix),
                profit: getInput(id, 'profit', pricePreffix),
                margin: getInput(id, 'margin', pricePreffix),
                commission: getInput(id, 'commission', pricePreffix),
                taxSimplesNacional: getInput(id, 'simplesNacional', pricePreffix),
                freight: getInput(id, 'freight', pricePreffix),
                differenceICMS: getInput(id, 'differenceICMS', pricePreffix),
                purchasePrice: getInput(id, 'purchasePrice', pricePreffix)
            },
            discountedPrice: {
                price: getInput(id, 'value', discountedPricePreffix),
                profit: getInput(id, 'profit', discountedPricePreffix),
                margin: getInput(id, 'margin', discountedPricePreffix),
                commission: getInput(id, 'commission', discountedPricePreffix),
                taxSimplesNacional: getInput(id, 'simplesNacional', discountedPricePreffix),
                freight: getInput(id, 'freight', discountedPricePreffix),
                differenceICMS: getInput(id, 'differenceICMS', discountedPricePreffix),
                purchasePrice: getInput(id, 'purchasePrice', discountedPricePreffix)
            }
        }

        function getInput (id, inputName, preffix) {
            return document.querySelector('#' + preffix + '-' + id + '-' + inputName)
        }

        function setColor(object, input, color) {
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

            calculator[object][input].style.backgroundColor = backgroundColor
            calculator[object][input].style.color = textColor
        }

        function setValue(object, input, value) {
            calculator[object][input].value = value
        }

        function setData(object, data) {
            setValue(object, 'price', data.suggestedPrice)
            setValue(object, 'profit', data.profit)
            setValue(object,'commission', data.commission)
            setValue(object,'taxSimplesNacional', data.taxSimplesNacional)
            setValue(object, 'freight', data.freight)
            setValue(object, 'differenceICMS', data.differenceICMS)
            setValue(object, 'purchasePrice', data.purchasePrice)
            setValue(object, 'margin', data.margin)

            setColor(object, 'commission', 'red')
            setColor(object, 'taxSimplesNacional', 'red')
            setColor(object, 'freight', 'red')
            setColor(object, 'differenceICMS', 'red')
            setColor(object, 'purchasePrice', 'red')

            data.profit > 0
                ? setColor(object, 'profit', 'green')
                : setColor(object, 'profit', 'red')

            data.margin > 0
                ? setColor(object, 'margin', 'green')
                : setColor(object, 'margin', 'red')
        }

        form.addEventListener('submit', (event) => {
            event.preventDefault()
            let formData = getFormData(form)

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .catch(error => console.error('Error:', error))
                .then(function(data) {
                    setData('price', data.price)

                    if (data.discountedPrice) {
                        setData('discountedPrice', data.discountedPrice)
                    }
                })
        })
    })
}

calculator_form()
