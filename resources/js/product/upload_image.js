import * as errorBox from "./error_box";

let uploadImageAPI = function() {
    if (window.location.pathname !== '/produtos/upload-de-imagens') {
        return;
    }

    var uploadImage = {
        formInput: {
            sku: document.querySelector('.input-sku'),
            name: document.querySelector('.input-name'),
            brand: document.querySelector('.input-brand')
        },
        errorBox: document.querySelector('#error-box')
    }

    async function getProduct(url) {
        var bearer = 'Bearer ' + tokenApiKey
        var options = {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Authorization': bearer
            },
        }

        await fetch(url, options)
            .then(function(data) {
                return data.json()
            })
            .then(function(data) {
                if (data.product) {
                    var files = Array.from(data.product.images)

                    var div = document.querySelector('.preview-image')
                    div.innerHTML = ''

                    var inputFile = document.querySelector('.input-file')
                    inputFile.value = ''

                    files.forEach(function(imageUrl, index) {
                        renderImages(div, imageUrl)
                    })

                    uploadImage.formInput.name.value = data.product.name
                }

                if (data.errors) {
                    errorBox.show(data.errors, uploadImage.errorBox)
                }
            })
            .catch(function(error) {
                errorBox.show(error, uploadImage.errorBox)
            })
    }

    uploadImage.formInput.sku.addEventListener('change', function () {
        const api_url = window.location.origin + '/api/product/' + this.value

        getProduct(api_url)
    });
}

let filePreview = function () {
    if (window.location.pathname !== '/produtos/upload-de-imagens') {
        return;
    }

    let inputFile = document.querySelector('.input-file');

    inputFile.addEventListener('change', function () {
        var files = Array.from(this.files)
        var div = document.querySelector('.preview-image')
        div.innerHTML = ''

        files.forEach(function(file, index) {
            var previewURL = URL.createObjectURL(file);
            renderImages(div, previewURL)
        })
    });
}

let renderImages = function (divComponent, url) {
    var imageContainter = document.createElement('div');
    var img = document.createElement('img');

    img.setAttribute('src', url);
    img.setAttribute('width', 180);
    img.style.margin = '12px'

    divComponent.append(imageContainter);
    imageContainter.append(img);
}

uploadImageAPI();
filePreview();
