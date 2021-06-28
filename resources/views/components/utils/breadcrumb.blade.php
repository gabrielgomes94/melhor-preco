<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach ($breadcrumb as $item)
            <li class="breadcrumb-item">
                <a href="{{ $item['link'] }}" class="text-primary">
                    {{ $item['name'] }}
                </a>
            </li>
        @endforeach
    </ol>
</nav>
