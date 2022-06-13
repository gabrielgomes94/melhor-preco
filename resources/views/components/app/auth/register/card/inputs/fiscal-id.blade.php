<label for="fiscalId">CNPJ ou CPF</label>
<div class="input-group">
    <span class="input-group-text" id="fiscalId">
        <svg class="icon icon-xs text-gray-600"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24"
             xmlns="http://www.w3.org/2000/svg"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
            </path>
        </svg>
    </span>

    <input name="fiscal_id"
           type="text"
           class="form-control"
           id="fiscalId"
           value="{{ old('fiscal_id') ?? '' }}"
           data-registration-fiscal-id
           required
    >
</div>
