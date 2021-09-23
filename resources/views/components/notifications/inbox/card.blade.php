<div class="card hover-state border-bottom py-3">
    <div class="card-body d-flex align-items-center flex-wrap flex-lg-nowrap py-0">
        <div class="w-100 ">
            @foreach ($notification['tags'] as $tag)
                <x-utils.badge>
                    {{ $tag }}
                </x-utils.badge>
            @endforeach

            <div class="d-flex align-items-center justify-content-between">
                <x-notifications.inbox.message-list.card :notification="$notification" />

{{--                @if ($notification['wasReaded'])--}}
{{--                    <div class="h6 mb-0">--}}
{{--                        <a href="{{ route('notifications.list', ['main' => $notification['id']]) }}">--}}
{{--                            {{ $notification['title'] }}--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                @else--}}
{{--                    <div class="h6 mb-0 fw-extrabold">--}}
{{--                        <a href="{{ route('notifications.list', ['main' => $notification['id']]) }}">--}}
{{--                            {{ $notification['title'] }}--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                @endif--}}

                <div>
                    {{ $notification['createdAt'] }}
                </div>
            </div>
        </div>
    </div>
</div>
