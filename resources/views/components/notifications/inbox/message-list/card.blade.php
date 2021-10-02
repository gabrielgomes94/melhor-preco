<div class="card hover-state border border-bottom py-3 mb-2">
    <div class="card-body d-flex align-items-center flex-wrap flex-lg-nowrap py-0">
        <div class="w-100">
            <x-notifications.notification.tags :tags="$notification->tags()" />

            <div class="d-flex align-items-center justify-content-between">
                <x-notifications.notification.readed-status
                    :notification="$notification"
                >
                    <x-notifications.notification.title
                        :title="$notification->title()"
                        :route="route('notifications.list', ['main' => $notification->id(), 'filter' => 'solved'])"
                    />
                </x-notifications.notification.readed-status>

                <div class="d-flex flex-column">
                    <div class="pb-1">
                        <x-notifications.notification.timestamp :notification="$notification" />
                    </div>

                    <div class="d-flex justify-content-end pt-1">
                        <x-notifications.notification.solved-badge :notification="$notification" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
