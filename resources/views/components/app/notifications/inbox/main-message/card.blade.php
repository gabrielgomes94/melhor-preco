<div class="shadow rounded main-notification-card" data-main-notification-id="{{ $notification->id() }}">
    <x-template.card.card>
        <x-app.notifications.inbox.main-message.card-header :notification="$notification" />

        <x-app.notifications.inbox.main-message.card-body :notification="$notification" />

        <x-app.notifications.inbox.main-message.card-footer :notification="$notification" />
    </x-template.card.card>
</div>
