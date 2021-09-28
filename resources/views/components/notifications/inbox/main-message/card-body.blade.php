<x-notifications.inbox.main-message.content>
    <div class="main-message-card-body">
        <div class="mb-4">
            <h3>{{ $notification->toArray()['title'] }}</h3>
        </div>

        <div>
            {{ $notification->toArray()['content'] }}
        </div>
    </div>
</x-notifications.inbox.main-message.content>
