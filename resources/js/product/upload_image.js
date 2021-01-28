import * as product from "./product";
product.getCEP()
console.log(product.requestOptions)

let uploadImageAPI = function() {
    var baseurl = window.location.origin+window.location.pathname;
    if (baseurl !== 'http://barrigudinha.test:8000/product/upload_images') {
        return;
    }

    var uploadImageInput = {
        input: document.querySelector('.input-sku'),
        inputName: document.querySelector('.input-name'),
        inputBrand: document.querySelector('.input-brand'),
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

        const response = await fetch(url, options)
            .then(function(data) {
                return data.json()
            })
            .then(function(data) {
                if (data.product) {
                    console.log('data')
                    console.log(data)
                    setFeedbackInfo(data.product)

                    uploadImageInput.inputName.value = data.product.name
                    uploadImageInput.inputBrand.value = data.product.brand
                }

                if (data.errors) {
                    console.log('12222222')
                    console.log(data.errors)
                    // addErrorMessage(data.errors[0].erro.msg)
                }
            })
            .catch(function(error) {
                // addErrorMessage(error)
            })
    }

    uploadImageInput.input.addEventListener('change', function () {
        const api_url = window.location.origin + '/api/product/' + this.value

        // Defining async function
        // async function getapi(url) {
        //     var bearer = 'Bearer ' + tokenApiKey
        //     var options = {
        //         method: 'GET',
        //         headers: {
        //             'Accept': 'application/json',
        //             'Authorization': bearer
        //         },
        //     }
        //     const response = await fetch(url, options)
        //         .then(function (data){
        //             return data.json()
        //         })
        //         .then(function (data){
        //             console.log('---1221212')
        //             console.log(data)
        //             uploadImageInput.inputName.value = data.name
        //             uploadImageInput.inputBrand.value = data.brand
        //         })
        //         .catch(function (){
        //             console.log('---ERROR')
        //             errorBox.innerHTML = data['errors']
        //             errorBox.classList.add("alert")
        //             errorBox.classList.add("alert-danger")
        //         })
        //
        //     var data = await response.json()
        //
        //     if (data['errors']) {
        //         return
        //     }
        //
        //     if (response) {
        //     }
        // }

        // getProduct(api_url);
    });
}

let filePreview = function () {
    var baseurl = window.location.origin+window.location.pathname;
    if (baseurl !== 'http://barrigudinha.test:8000/product/upload_images') {
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
