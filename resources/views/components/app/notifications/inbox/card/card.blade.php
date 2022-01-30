<div class="my-2 mb-4">
    <x-template.card.card>
        <x-template.card.card-body>
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
        </x-template.card.card-body>
    </x-template.card.card>
</div>
