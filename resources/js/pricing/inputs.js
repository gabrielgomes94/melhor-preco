import IMask from 'imask';

document.addEventListener('DOMContentLoaded', (event) => {
    var moneyElements = document.querySelectorAll('.input-money');
    var percentageElements = document.querySelectorAll('.input-percentage');

    var maskOptions = {
        mask: Number,
        scale: 2,
        signed: false,
        thousandsSeparator: '.',
        padFractionalZeros: true,
        normalizeZeros: true,
        radix: ',',
        mapToRadix: ['.'],
    };

    moneyElements.forEach(function(element){
        var mask = IMask(element, maskOptions);

        element.addEventListener('change', function () {
            var inputId = this.id.replace('-input-view', '');
            var input = document.querySelector('#' + inputId)
            input.value = mask.unmaskedValue;
        })
    });

    percentageElements.forEach(function (element){
        var mask = IMask(element, maskOptions);

        element.addEventListener('change', function () {
            var inputId = this.id.replace('-input-view', '');
            var input = document.querySelector('#' + inputId);
            input.value = mask.unmaskedValue;
        })
    })
})
