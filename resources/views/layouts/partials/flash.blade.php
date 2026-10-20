{{-- Toast untuk feedback aksi dan validasi, tampil di atas konten halaman. --}}
@if(session('success') || session('error') || (($showErrors ?? true) && $errors->any()))
    <div class="toast-stack" aria-live="polite" aria-atomic="false">
        @if(session('success'))
            <div class="alert alert--success toast" role="status">
                <x-icon name="circle-check" />
                <div class="alert__title">Sukses!</div>
                <div class="alert__description">{{ session('success') }}</div>
                <button type="button" class="toast__dismiss" aria-label="Tutup notifikasi" data-toast-dismiss>&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert--danger toast" role="alert">
                <x-icon name="circle-x" />
                <div class="alert__title">Error!</div>
                <div class="alert__description">{{ session('error') }}</div>
                <button type="button" class="toast__dismiss" aria-label="Tutup notifikasi" data-toast-dismiss>&times;</button>
            </div>
        @endif

        @if(($showErrors ?? true) && $errors->any())
            <div class="alert alert--danger toast" role="alert">
                <x-icon name="circle-x" />
                <div class="alert__title">Terjadi kesalahan:</div>
                <div class="alert__description">
                    <ul class="list-disc ps-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="toast__dismiss" aria-label="Tutup notifikasi" data-toast-dismiss>&times;</button>
            </div>
        @endif
    </div>
@endif
