<div class="modal fade"
     id="{{ $id }}"
     tabindex="-1"
     aria-labelledby="{{ "{$id}-title-labels" }}"
     aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ "{$id}-title-labels" }}">{{ $title }}</h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Fechar">
                </button>
            </div>

            <div class="modal-body">
                {{ $slot }}
            </div>

            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                >
                    Fechar
                </button>

                <button type="submit"
                        class="btn btn-primary"
                        form="{{ $formId }}"
                >
                    {{ $actionLabel }}
                </button>
            </div>
        </div>
    </div>
</div>
