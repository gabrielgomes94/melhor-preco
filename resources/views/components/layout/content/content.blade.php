<main class="content">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-start">
                {{ $navbar ?? ''}}
            </div>
        </div>

        <div class="col-12">
            @isset($header)
                <header class="header header-page py-4">
                    <div class="mx-auto">
                        <h2 class="display-3    "> {{ $header ?? ''}}</h2>
                    </div>
                </header>
            @endisset
        </div>

        <div class="col-12">
            <div class="mx-auto">
                {{ $breadcrumb ?? '' }}
            </div>

            <div class="row">
                <div class="col-12">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</main>