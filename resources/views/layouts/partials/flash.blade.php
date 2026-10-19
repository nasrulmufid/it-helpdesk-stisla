{{-- Pesan flash & error validasi memakai komponen .alert --}}
@if(session('success'))
    <div class="alert alert--success" role="alert">
        <x-icon name="circle-check" />
        <div class="alert__title">Sukses!</div>
        <div class="alert__description">{{ session('success') }}</div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert--danger" role="alert">
        <x-icon name="circle-x" />
        <div class="alert__title">Error!</div>
        <div class="alert__description">{{ session('error') }}</div>
    </div>
@endif

@if(($showErrors ?? true) && $errors->any())
    <div class="alert alert--danger" role="alert">
        <x-icon name="circle-x" />
        <div class="alert__title">Terjadi kesalahan:</div>
        <div class="alert__description">
            <ul class="list-disc ps-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
