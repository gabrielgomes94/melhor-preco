import IMask from 'imask';


document.addEventListener('DOMContentLoaded', (event) => {

    console.log('showowow');
    var element = document.querySelector('.input-money');
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
    var mask = IMask(element, maskOptions);

    //the event occurred
})
