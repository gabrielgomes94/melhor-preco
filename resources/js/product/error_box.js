export function show(errorMessage, errorBox) {
    errorBox.innerHTML = errorMessage
    errorBox.classList.remove("d-none")
    errorBox.classList.add("alert")
    errorBox.classList.add("alert-danger")

    setTimeout(function(){
        errorBox.classList.add('d-none');
    }, 3600);
}
