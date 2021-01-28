export function show(errors, errorBox) {
    errorBox.innerHTML = "<ul></ul>"
    errors.forEach(function(error, index) {
        let errorMessage = document.createElement('li')
        errorMessage.innerHTML = error.erro.msg
        errorBox.append(errorMessage)
    });

    errorBox.classList.remove("d-none")
    errorBox.classList.add("alert")
    errorBox.classList.add("alert-danger")

    setTimeout(function(){
        errorBox.classList.add('d-none');
    }, 4200);
}
