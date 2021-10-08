<div class="p-2">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex">
            <x-notifications.notification.timestamp :notification="$notification" />
        </div>

        <div class="d-flex">
            <ul class="nav d-flex d-flex align-items-center">
                <li class="nav-item">
                    <x-notifications.notification.solved-badge :notification="$notification" />
                </li>

                <li class="nav-item dropstart">
                    <x-notifications.notification.status-dropdown :notification="$notification" />
                </li>
            </ul>
        </div>
    </div>
</div>
