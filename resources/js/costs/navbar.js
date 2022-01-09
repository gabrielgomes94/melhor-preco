let highlightNavbarSection = function () {
    function isProductCostsPage() {
        return window.location.pathname.includes('custos/produtos')
    }

    function isInvoicePage() {
        return window.location.pathname.includes('custos/notas-fiscais')
    }

    function getActiveSection() {
        if (isProductCostsPage()) {
            return document.querySelector('#nav-product-costs')
        } else if (isInvoicePage()) {
            return document.querySelector('#nav-invoice-costs')
        }

        return null
    }

    let section = getActiveSection()
    if (section == null) {
        return
    }

    section.querySelector('.nav-link').style.color = '#fff'
    section.style.backgroundColor = '#1F2937'
}

highlightNavbarSection()
