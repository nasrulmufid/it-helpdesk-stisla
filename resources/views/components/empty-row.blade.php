@props(['colspan' => 1, 'icon' => 'inbox', 'title' => 'Belum ada data', 'text' => null])
{{-- Baris tabel kosong memakai komponen .empty-state. Slot default = tombol aksi (opsional). --}}
<tr>
    <td colspan="{{ $colspan }}">
        <div class="empty-state empty-state--sm">
            <span class="empty-state__media"><x-icon :name="$icon" /></span>
            <h3 class="empty-state__title">{{ $title }}</h3>
            @if($text)<p class="empty-state__text">{{ $text }}</p>@endif
            @if(trim((string) $slot) !== '')
                <div class="empty-state__action">{{ $slot }}</div>
            @endif
        </div>
    </td>
</tr>
