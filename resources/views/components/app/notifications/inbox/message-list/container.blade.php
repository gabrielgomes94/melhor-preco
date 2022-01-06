<div class="message-wrapper border-2 bg-white p-2">
    @foreach ($notifications as $notification)
        <x-app.notifications.inbox.message-list.card :notification="$notification" :filter="$filter">
        </x-app.notifications.inbox.message-list.card>
    @endforeach
</div>
