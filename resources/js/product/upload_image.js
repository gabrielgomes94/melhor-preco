import * as errorBox from "./error_box";

let uploadImageAPI = function() {
    if (window.location.pathname !== '/product/upload_images') {
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
                    uploadImage.formInput.name.value = data.product.name
                    uploadImage.formInput.brand.value = data.product.brand
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
    if (window.location.pathname !== '/product/upload_images') {
        return;
    }

    let inputFile = document.querySelector('.input-file');

    inputFile.addEventListener('change', function () {
        var files = Array.from(this.files)

        files.forEach(function(file, index) {

            var previewURL = URL.createObjectURL(file);
            var div = document.querySelector('.preview-image');
            var imageContainter = document.createElement('div');
            var img = document.createElement("img");

            img.setAttribute('src', previewURL);
            img.setAttribute('width', 180);
            img.style.margin = '12px'
            div.append(imageContainter);
            imageContainter.append(img);
        })
    });
}

uploadImageAPI();
filePreview();
