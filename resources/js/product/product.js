// // Defining async function
// var productGet = async function getapi(url) {
//     inputName.value = ''
//     inputStockAmount.value = ''
//     var bearer = 'Bearer ' + tokenApiKey
//
//     var options = {
//         method: 'GET',
//         headers: {
//             'Accept': 'application/json',
//             'Authorization': bearer
//         },
//     }
//     const response = await fetch(url, options)
//
//     var data = await response.json()
//
//     // console.log(data)
//     if (data['errors']) {
//         errorBox.innerHTML = data['errors']
//         errorBox.classList.add("alert")
//         errorBox.classList.add("alert-danger")
//
//         return
//     }
//
//     if (response) {
//         inputName.value = data['products'][0]['name']
//         inputStockAmount.value = data['products'][0]['stock']
//     }
// }
//
// productGet(1232)

// let requestOptions = {
//     method: 'GET',
//     headers: {
//         'Accept': 'application/json',
//         'Authorization': 'Bearer ' + tokenApiKey
//     },
// }

export function getCEP() {
    console.log('vish')
}

export let requestOptions = {
    method: 'GET',
    headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + tokenApiKey
    },
}
