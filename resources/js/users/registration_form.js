import IMask from 'imask';

document.addEventListener('DOMContentLoaded', (event) => {
    var phoneInput = document.querySelector('[data-registration-phone]')

    if (!phoneInput) {
        return
    }

    IMask(phoneInput, {
        mask: [
            {
                mask: '(00) 0000-0000',
            },
            {
                mask: '(00) 0 0000-0000',
            }
        ]
    })

    var fiscalIdInput = document.querySelector('[data-registration-fiscal-id]')
    if (!fiscalIdInput) {
        return
    }

    IMask(fiscalIdInput, {
        mask: [
            {
                mask: '000.000.000-00'
            },
            {
                mask: '00.000.000/0000-00'
            }
        ]
    })
})
