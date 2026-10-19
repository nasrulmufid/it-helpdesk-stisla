{{-- Pilihan role berbentuk kartu. Param: $current (role terpilih saat ini) --}}
<div class="field">
    <span class="field__label" id="role-label">Role <span class="text-danger-emphasis">*</span></span>
    <div class="choice-grid" role="radiogroup" aria-labelledby="role-label">
        @foreach([
            ['admin', 'Admin', 'Full Access', 'Akses penuh ke sistem', 'danger'],
            ['general_manager', 'General Manager', 'Manager', 'View reports & analytics', 'primary'],
            ['technician', 'Teknisi', 'Support', 'Handle & resolve tickets', 'info'],
            ['user', 'User', 'Standard', 'Create & view own tickets', null],
        ] as [$value, $title, $tag, $text, $tone])
            <label class="choice-card">
                <input type="radio" name="role" value="{{ $value }}" class="radio mt-0.5" {{ old('role', $current) == $value ? 'checked' : '' }}>
                <span class="flex flex-col gap-1 min-w-0">
                    <span class="flex flex-wrap items-center gap-2">
                        <span class="choice-card__title">{{ $title }}</span>
                        <span class="badge badge--soft {{ $tone ? "badge--$tone" : '' }}">{{ $tag }}</span>
                    </span>
                    <span class="choice-card__text">{{ $text }}</span>
                </span>
            </label>
        @endforeach
    </div>
    <x-form-error name="role" />
</div>
