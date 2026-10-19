@extends('layouts.app')

@section('title', 'Buat Tiket Baru')

@section('content')
    <x-page-header title="Buat Tiket Baru"
        description="Laporkan masalah IT Anda dan dapatkan bantuan dari tim support"
        :back="route('tickets.index')" back-label="Kembali ke Daftar Tiket" />

    <div class="page__body">
        <div class="card max-w-3xl">
            <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="card__body flex flex-col gap-5">
                    <div class="field">
                        <label for="title" class="field__label">Judul Tiket <span class="text-danger-emphasis">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" class="input"
                            placeholder="Contoh: Laptop tidak bisa menyala" required
                            @error('title') aria-invalid="true" aria-describedby="title-error" @enderror>
                        <x-form-error name="title" />
                    </div>

                    <div class="field">
                        <label for="category_id" class="field__label">Kategori <span class="text-danger-emphasis">*</span></label>
                        <select id="category_id" name="category_id" class="select" required
                            @error('category_id') aria-invalid="true" aria-describedby="category_id-error" @enderror>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->icon }} {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-form-error name="category_id" />
                    </div>

                    <div class="field">
                        <span class="field__label" id="priority-label">Prioritas <span class="text-danger-emphasis">*</span></span>
                        <div class="choice-grid" role="radiogroup" aria-labelledby="priority-label">
                            @foreach([
                                ['low', 'Rendah', '🟢'],
                                ['medium', 'Sedang', '🟡'],
                                ['high', 'Tinggi', '🟠'],
                                ['critical', 'Kritis', '🔴'],
                            ] as [$value, $label, $emoji])
                                <label class="choice-card choice-card--center">
                                    <input type="radio" name="priority" value="{{ $value }}" class="sr-only"
                                        {{ old('priority', 'medium') == $value ? 'checked' : '' }}>
                                    <span class="text-2xl leading-none">{{ $emoji }}</span>
                                    <span class="choice-card__title">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-form-error name="priority" />
                    </div>

                    <div class="field">
                        <label for="description" class="field__label">Deskripsi <span class="text-danger-emphasis">*</span></label>
                        <textarea id="description" name="description" rows="6" class="textarea"
                            placeholder="Jelaskan masalah Anda secara detail..." required
                            aria-describedby="description-hint{{ $errors->has('description') ? ' description-error' : '' }}"
                            @error('description') aria-invalid="true" @enderror>{{ old('description') }}</textarea>
                        <p class="field__description" id="description-hint">Berikan informasi sebanyak mungkin agar kami bisa membantu dengan lebih cepat</p>
                        <x-form-error name="description" />
                    </div>

                    <div class="field">
                        <span class="field__label">Lampiran <span class="text-muted-foreground font-normal">(opsional)</span></span>
                        <label for="attachments" class="dropzone">
                            <input type="file" id="attachments" name="attachments[]" multiple class="sr-only" data-file-input>
                            <x-icon name="upload" class="text-2xl" />
                            <span class="font-medium">Klik untuk unggah atau seret file ke sini</span>
                            <span class="text-xs">JPG, PNG, PDF, DOCX (Maks. 5MB per file)</span>
                        </label>
                        <ul class="list-group list-group--block mt-2" id="file-list" aria-live="polite"></ul>
                        <x-form-error name="attachments.*" />
                    </div>
                </div>

                <div class="card__footer flex-wrap justify-end gap-2">
                    <a href="{{ route('tickets.index') }}" class="button button--neutral button--outline">Batal</a>
                    <button type="submit" class="button button--primary"><x-icon name="send" /> Buat Tiket</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Tampilkan daftar file yang dipilih (nama dibuat lewat textContent agar aman dari XSS).
        document.querySelector('[data-file-input]').addEventListener('change', function () {
            const list = document.getElementById('file-list');
            list.replaceChildren();
            Array.from(this.files).forEach(function (file) {
                const li = document.createElement('li');
                li.className = 'list-group__item flex items-center gap-2';
                const name = document.createElement('span');
                name.className = 'truncate flex-1';
                name.textContent = file.name;
                const size = document.createElement('span');
                size.className = 'text-xs text-muted-foreground';
                size.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                li.append(name, size);
                list.appendChild(li);
            });
        });
    </script>
@endsection
