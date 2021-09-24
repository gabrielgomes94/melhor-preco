<div class="message-wrapper bg-white shadow rounded ">
    <x-template.card.card>
        <x-notifications.inbox.main-message.content>
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
                            <a class="nav-link text-dark dropdown-toggle p-2"
                               data-unread-notifications="true"
                               href="#"
                               role="button"
                               data-bs-toggle="dropdown"
                               data-bs-display="static"
                               aria-expanded="false"
                            >
                                <x-layout.icons.mini-menu />
                            </a>

                            <div class="dropdown-menu my-4">
                                <div class="list-group list-group-flush">
                                    <a href="#" class="text-center text-primary fw-bold border-bottom border-light">
                                        Marcar como resolvido
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </x-notifications.inbox.main-message.content>

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

        <x-notifications.inbox.main-message.content>

            <div class="main-message-card-tags">
                <x-notifications.notification.tags :tags="$notification->tags()" />
            </div>
        </x-notifications.inbox.main-message.content>
    </x-template.card.card>
</div>
