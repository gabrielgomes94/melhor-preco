<div class="message-wrapper border-2 shadow bg-white p-2">
    @foreach ($notifications as $notification)
        <x-notifications.inbox.message-list.card :notification="$notification">
        </x-notifications.inbox.message-list.card>
    @endforeach
</div>
