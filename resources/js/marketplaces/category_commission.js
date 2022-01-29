let setChildrenCategory = function () {
    let inputs = document.querySelectorAll('.input-commission')

    inputs.forEach(function (element) {
        element.addEventListener("change", function () {
            let value = element.value

            let commissionInputs = Array.from(
                document.querySelectorAll('td[data-parent-id]')
            )

            let categoryId = element.closest('.category-commission-row')
                .querySelector('.input-category-id')
                .value

            commissionInputs = commissionInputs.filter(function (element) {
                return element.getAttribute('data-parent-id')  === categoryId
            }, categoryId)

            commissionInputs.forEach(function (element) {
                input = element.querySelector('.input-commission')
                input.value = value
                input.dispatchEvent(new Event('change'))
            }, value)
        })
    })
}

setChildrenCategory()
