require('./bootstrap');

let input = document.querySelector('.input-sku');
let inputName = document.querySelector('.input-name');
let inputBrand = document.querySelector('.input-brand');
let inputDescription = document.querySelector('.input-main-description');

input.addEventListener('change', function () {
    const base = window.location.href
    const api_url = base + "api/product/" + this.value;

    // Defining async function
    async function getapi(url) {
        const response = await fetch(url);

        var data = await response.json();

        if (response) {
            inputName.value = data['descricao']
            inputBrand.value = data['marca']
            inputDescription.textContent = data['descricaoCurta']
        }
    }

    getapi(api_url);
});

let inputFile = document.querySelector('.input-file');
inputFile.addEventListener('change', function () {
    var mime_types = [ 'image/jpeg', 'image/png' ];
    var files = Array.from(this.files)

    files.forEach(function(file, index) {
        if(mime_types.indexOf(file.type) == -1) {
            alert('Error : Incorrect file type');
            return;
        }

        _PREVIEW_URL = URL.createObjectURL(file);
        var div = document.querySelector('.preview-image');
        var img = document.createElement("img");

        img.setAttribute('src', _PREVIEW_URL);
        img.setAttribute('width', 180);
        img.style.margin = '12px'
        div.append(img);
    })
});
