<div class="d-flex justify-content-between mb-2">
    <nav class="w-100">
        <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
            <a class="nav-item nav-link {{ ($selectedNav == 'integrations') ? 'active' : '' }}"
               id="nav-settings-integrations-tab"
               role="tab" aria-controls="nav-home" aria-selected="true"
               href="{{ route('users.settings.integrations') }}"
            >
                Integrações
            </a>

            <div class="mx-1"></div>

            <a class="nav-item nav-link {{ ($selectedNav == 'marketplaces') ? 'active' : '' }}"
               id="nav-settings-marketplaces-tab"
               role="tab" aria-controls="nav-profile" aria-selected="false"
               href="{{ route('marketplaces.list') }}"
            >
                Marketplaces
            </a>

            <div class="mx-1"></div>

            <a class="nav-item nav-link {{ ($selectedNav == 'taxes') ? 'active' : '' }}"
               id="nav-settings-taxes-tab"
               href="{{ route('users.settings.taxes') }}"
               role="tab" aria-controls="nav-contact" aria-selected="false"
            >
                Impostos
            </a>

            <div class="mx-1"></div>

            <a class="nav-item nav-link {{ ($selectedNav == 'profile') ? 'active' : '' }}"
               id="nav-settings-profile-tab"
               href="{{ route('users.settings.profile') }}"
               role="tab" aria-controls="nav-contact" aria-selected="false"
            >
                Informações da Conta
            </a>
        </div>
    </nav>
</div>
