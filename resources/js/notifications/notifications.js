let showNotificationsBadge = function () {
    function setBadge(notificationsCount) {
        let sections = document.querySelectorAll('.notifications-badge-section')

        sections.forEach(function (section) {
            section.innerHTML = "<span class='badge badge-sm bg-danger m-1 p-2 text-white rounded-pill '>" + notificationsCount + "</span>"
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

showNotificationsBadge()
