{{-- Field form kategori. Param: $category (null saat membuat baru) --}}
<div class="field">
    <label for="name" class="field__label">Nama Kategori <span class="text-danger-emphasis">*</span></label>
    <input type="text" name="name" id="name" value="{{ old('name', $category?->name) }}" class="input"
        placeholder="Contoh: Hardware, Software, Network" required
        @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
    <x-form-error name="name" />
</div>

<div class="field">
    <label for="slug" class="field__label">Slug <span class="text-muted-foreground font-normal">(opsional, akan dibuat otomatis)</span></label>
    <input type="text" name="slug" id="slug" value="{{ old('slug', $category?->slug) }}" class="input"
        placeholder="hardware-issues" aria-describedby="slug-hint"
        @error('slug') aria-invalid="true" @enderror>
    <p class="field__description" id="slug-hint">URL-friendly version dari nama kategori</p>
    <x-form-error name="slug" />
</div>

<div class="field">
    <label for="icon" class="field__label">Icon/Emoji <span class="text-danger-emphasis">*</span></label>
    <div class="flex flex-wrap items-center gap-3">
        <input type="text" name="icon" id="icon" value="{{ old('icon', $category?->icon ?? '📁') }}" maxlength="2"
            class="input w-20 text-center text-xl" required @error('icon') aria-invalid="true" aria-describedby="icon-error" @enderror>
        <div class="flex flex-wrap gap-1" aria-label="Pilihan cepat emoji">
            @foreach(['💻', '🖥️', '🔧', '🌐', '🔐', '📱', '🖨️', '📁'] as $emoji)
                <button type="button" class="button button--sm button--outline button--neutral button--icon-only"
                    onclick="document.getElementById('icon').value='{{ $emoji }}'" aria-label="Pilih {{ $emoji }}">{{ $emoji }}</button>
            @endforeach
        </div>
    </div>
    <x-form-error name="icon" />
</div>

<div class="field">
    <label for="description" class="field__label">Deskripsi</label>
    <textarea name="description" id="description" rows="4" class="textarea"
        placeholder="Deskripsi singkat tentang kategori ini..."
        @error('description') aria-invalid="true" aria-describedby="description-error" @enderror>{{ old('description', $category?->description) }}</textarea>
    <x-form-error name="description" />
</div>

<div class="field">
    <div class="field__item">
        <input type="checkbox" name="is_active" id="is_active" value="1" class="checkbox"
            {{ old('is_active', $category?->is_active ?? true) ? 'checked' : '' }}>
        <label for="is_active" class="field__label">Kategori Aktif</label>
    </div>
    <p class="field__description">Pengguna dapat memilih kategori ini saat membuat tiket</p>
    <x-form-error name="is_active" />
</div>
