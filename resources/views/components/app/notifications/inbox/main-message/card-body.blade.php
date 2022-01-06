<div class="main-message-card-body">
    <div class="mb-4">
        <h3>{{ $notification->title() }}</h3>
    </div>

    <x-app.notifications.inbox.main-message.content :notification="$notification" />
</div>
