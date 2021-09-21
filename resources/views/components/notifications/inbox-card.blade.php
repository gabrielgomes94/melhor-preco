<div class="row">
    <div class="col-4">
        <div class="message-wrapper border-0 bg-white shadow">
            @foreach ($notifications as $notification)
                <x-notifications.list.card :notifications="$notification"/>
            @endforeach
        </div>

        {{--        <x-utils.paginator-links />--}}
    </div>

    <div class="col-8">
        <x-notifications.main-box.content :mainNotification="$mainNotification" />
    </div>
</div>
