<label for="name">Nome</label>
<div class="input-group">
    <span class="input-group-text" id="name">
        <svg class="icon icon-xs text-gray-600"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24"
             xmlns="http://www.w3.org/2000/svg"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
    </span>
    <input name="name" type="text" class="form-control" id="name" value="{{ old('name') ?? '' }}" required>
</div>
