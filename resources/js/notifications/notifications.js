let showNotificationsBadge = function () {
    function setBadge(notificationsCount) {
        let sections = document.querySelectorAll('.notifications-badge-section')

        sections.forEach(function (section) {
            section.innerHTML = "<span class='badge badge-sm bg-danger m-1 p-2 text-white rounded-circle '>" + notificationsCount + "</span>"
        })
    }

    async function getNotificationsCount() {
        let url = window.location.origin + '/api/notifications/count'
        var options = {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + tokenApiKey
            },
        }

        await fetch(url, options)
            .then(function(data) {
                return data.json()
            })
            .then(function(data) {
                if (data.count > 0)
                    setBadge(data.count)
            })
    }

    getNotificationsCount()
}

let highlightNavbarSection = function () {
    function isInboxPage() {
        return window.location.pathname === '/notifications/inbox' && window.location.search === ''
    }

    function isInboxSolvedPage() {
        return window.location.search.includes('filter=solved')
    }

    function getActiveSection() {
        if (isInboxPage()) {
            return document.querySelector('#inbox-nav-link')
        } else if (isInboxSolvedPage()) {
            return document.querySelector('#inbox-solved-nav-link')
        }

        return null
    }

    let section = getActiveSection()
    if (section == null) {
        return
    }

    section.style.borderBottom = '2px #2361ce solid'
}

let highlightNotification = function () {
    let mainNotificationId = document.querySelector('.main-notification-card')
    let cards = document.querySelectorAll('.notification-card')

    cards.forEach(function (card) {
        if (card.dataset.notificationId === mainNotificationId.dataset.mainNotificationId) {
            card.style.backgroundColor = '#e5e7eb';
        }
    })
}

showNotificationsBadge()
highlightNavbarSection()
highlightNotification()
