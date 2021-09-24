@foreach ($notifications as $notification)
    <x-notifications.inbox.message-list.card :notification="$notification" />
@endforeach
