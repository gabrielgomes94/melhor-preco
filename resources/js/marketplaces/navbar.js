let highlightNavbarSection = function () {
    function getActiveSection() {
        return document.querySelector('#nav-marketplaces-list')
    }

    //@todo: refatorar esse trecho para evitar duplicação
    function colorSection() {
        let section = getActiveSection()
        if (section == null) {
            return
        }

        section.querySelector('.nav-link').style.color = '#fff'
        section.style.backgroundColor = '#1F2937'
    }

    colorSection()
}

highlightNavbarSection()
