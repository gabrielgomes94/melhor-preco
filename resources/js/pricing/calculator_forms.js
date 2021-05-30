let calculator_form = function() {
    var forms = document.querySelectorAll('.price-calculator-form')

    forms.forEach(function(form){
        var id = form.dataset.priceId
        var commission = form.querySelector('#commission-' + id).value
        var additionalCosts = form.querySelector('#additionalCosts-' + id).value

        var desiredPriceInputView = form.querySelector('#desiredPrice-' + id + '-input-view')
        var desiredPriceInput = form.querySelector('#desiredPrice-' + id)
        var desiredPrice = desiredPriceInput.value

        var product = form.querySelector('#product-' + id).value

        form.addEventListener('submit', (event) => {
            event.preventDefault()
            // var form = event.target
            var id = form.dataset.priceId
            var commission = form.querySelector('#commission-' + id).value
            var additionalCosts = form.querySelector('#additionalCosts-' + id).value

            var desiredPriceInputView = form.querySelector('#desiredPrice-' + id + '-input-view')
            var desiredPriceInput = form.querySelector('#desiredPrice-' + id)
            var desiredPrice = desiredPriceInput.value

            var product = form.querySelector('#product-' + id).value

            var formData = new FormData()
            formData.append('commission', commission)
            formData.append('additionalCosts', additionalCosts)
            formData.append('desiredPrice', desiredPrice)
            formData.append('product', product)

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .catch(error => console.error('Error:', error))
                .then(function(data) {
                    var updatePriceInput = document.querySelector('#update-price-' + id + '-value')
                    var updateProfitInput = document.querySelector('#update-price-' + id + '-profit')
                    var updateMarginInput = document.querySelector('#update-price-' + id + '-margin')

                    updatePriceInput.value = data.price.suggestedPrice
                    updateProfitInput.value = data.price.profit
                    if (updateProfitInput.value > 0) {
                        updateProfitInput.style.backgroundColor = '#198754';
                        updateProfitInput.style.color = '#fff';
                    } else if(updateProfitInput.value < 0) {
                        updateProfitInput.style.backgroundColor = '#dc3545';
                        updateProfitInput.style.color = '#fff';
                    } else {
                        updateProfitInput.style.backgroundColor =  '#e9ecef'
                        updateProfitInput.style.color = '#222';
                    }

                    updateMarginInput.value = data.price.margin
                })
        })
    })
}

calculator_form()
