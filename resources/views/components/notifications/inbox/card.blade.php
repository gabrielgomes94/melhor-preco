<div class="my-2 mb-4">
    <x-template.card.card>
        <x-notifications.inbox.card.small
            :mainNotification="$mainNotification"
            :paginator="$paginator"
        >
        </x-notifications.inbox.card.small>

        <x-notifications.inbox.card.large
            :mainNotification="$mainNotification"
            :paginator="$paginator"
        >
        </x-notifications.inbox.card.large>
    </x-template.card.card>
</div>
