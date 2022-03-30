<div class="my-2 mb-4">
    <x-bootstrap.card.basic.card>
        <x-bootstrap.card.basic.card-body>
            <x-app.notifications.inbox.card.small
                :mainNotification="$inbox->mainNotification()"
                :paginator="$inbox->paginator()"
                :filter="$filter"
            >
            </x-app.notifications.inbox.card.small>

            <x-app.notifications.inbox.card.large
                :mainNotification="$inbox->mainNotification()"
                :paginator="$inbox->paginator()"
                :filter="$filter"
            >
            </x-app.notifications.inbox.card.large>
        </x-bootstrap.card.basic.card-body>
    </x-bootstrap.card.basic.card>
</div>
