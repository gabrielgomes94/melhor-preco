<div class="row">
    <div class="col-6">
        <div class="message-wrapper border-0 bg-white shadow">
            @foreach ($notifications as $notification)
                <x-notifications.inbox.card :notification="$notification"/>
            @endforeach
        </div>

        <div class="mt-4">
{{--            <x-utils.paginator-links :paginator="$paginator"/>--}}
        </div>
    </div>

    <div class="col-6">
        <x-notifications.main-box.content :mainNotification="$mainNotification" />
    </div>
</div>
