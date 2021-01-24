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

    uploadImageInput.input.addEventListener('change', function () {
        const api_url = window.location.origin + '/api/product/' + this.value

        // Defining async function
        async function getapi(url) {
            const response = await fetch(url)

            var data = await response.json()

            if (data['errors']) {
                errorBox.innerHTML = data['errors']
                errorBox.classList.add("alert")
                errorBox.classList.add("alert-danger")

                return
            }

            if (response) {
                uploadImageInput.inputName.value = data['descricao']
                uploadImageInput.inputBrand.value = data['marca']
            }
        }

        getapi(api_url);
    });
}

let filePreview = function () {
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
