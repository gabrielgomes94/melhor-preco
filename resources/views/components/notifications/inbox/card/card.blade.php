<div class="my-2 mb-4">
    <x-template.card.card>
        <x-notifications.inbox.card.small
            :mainNotification="$inbox->mainNotification()"
            :paginator="$inbox->paginator()"
            :filter="$filter"
        >
        </x-notifications.inbox.card.small>

        <x-notifications.inbox.card.large
            :mainNotification="$inbox->mainNotification()"
            :paginator="$inbox->paginator()"
            :filter="$filter"
        >
        </x-notifications.inbox.card.large>
    </x-template.card.card>
</div>
