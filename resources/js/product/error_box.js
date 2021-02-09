export function show(errors, errorBox) {
    errorBox.innerHTML = "<ul class='list-group'></ul>"
    errors.forEach(function(error, index) {
        let errorMessage = document.createElement("li")
        errorMessage.classList.add("list-group-item")
        errorMessage.classList.add("list-group-item-danger")

        errorMessage.innerHTML = error
        errorBox.append(errorMessage)
    });

    errorBox.classList.remove("d-none")

    setTimeout(function(){
        errorBox.classList.add('d-none');
    }, 4200);
}
