@extends('layouts.app')

@section('title', 'Detail Tiket #' . $ticket->ticket_number)

@section('content')
    @php($authUser = auth()->user())
    @php($canManage = $authUser->isAdmin() || $authUser->isTechnician())

    <x-page-header :title="'Tiket #' . $ticket->ticket_number"
        :back="route('tickets.index')" back-label="Kembali ke Daftar Tiket">
        <x-slot:meta>
            <x-priority-badge :ticket="$ticket" />
            <x-status-badge :ticket="$ticket" />
        </x-slot:meta>
    </x-page-header>

    <div class="page__body">
        <div class="grid gap-6 lg:grid-cols-3 items-start">
            {{-- Kolom utama --}}
            <div class="lg:col-span-2 flex flex-col gap-6">
                {{-- Detail tiket --}}
                <div class="card">
                    <div class="card__header">
                        <h2 class="card__title">{{ $ticket->title }}</h2>
                    </div>
                    <div class="card__body flex flex-col gap-6">
                        <dl class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-xs text-muted-foreground">Kategori</dt>
                                <dd class="font-medium mt-1">{{ $ticket->category->icon }} {{ $ticket->category->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-muted-foreground">Dibuat oleh</dt>
                                <dd class="mt-1 flex items-center gap-2">
                                    <x-avatar :name="$ticket->user->name" />
                                    <span class="font-medium">{{ $ticket->user->name }}</span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs text-muted-foreground">Tanggal</dt>
                                <dd class="font-medium mt-1">{{ $ticket->created_at->format('d F Y H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-muted-foreground">Ditugaskan kepada</dt>
                                <dd class="mt-1">
                                    @if($ticket->assignedTo)
                                        <span class="flex items-center gap-2">
                                            <x-avatar :name="$ticket->assignedTo->name" />
                                            <span class="font-medium">{{ $ticket->assignedTo->name }}</span>
                                        </span>
                                    @else
                                        <span class="text-muted-foreground italic">Belum ditugaskan</span>
                                    @endif
                                </dd>
                            </div>
                        </dl>

                        <hr class="separator">

                        <div>
                            <h3 class="font-semibold mb-2">Deskripsi</h3>
                            <p class="whitespace-pre-line text-muted-foreground">{{ $ticket->description }}</p>
                        </div>

                        @if($ticket->attachments->count() > 0)
                            <div>
                                <h3 class="font-semibold mb-3">Lampiran ({{ $ticket->attachments->count() }})</h3>
                                <div class="grid gap-3 sm:grid-cols-2">
                                    @foreach($ticket->attachments as $attachment)
                                        <div class="card">
                                            @if(Str::startsWith($attachment->file_type, 'image/'))
                                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" rel="noopener">
                                                    <img src="{{ asset('storage/' . $attachment->file_path) }}" alt="{{ $attachment->file_name }}"
                                                        class="card__image w-full h-32 object-cover" loading="lazy">
                                                </a>
                                            @endif
                                            <div class="card__body">
                                                <div class="media">
                                                    @unless(Str::startsWith($attachment->file_type, 'image/'))
                                                        <div class="media__figure">
                                                            <span class="icon-box icon-box--primary"><x-icon name="file-text" /></span>
                                                        </div>
                                                    @endunless
                                                    <div class="media__content min-w-0">
                                                        <div class="media__title truncate" title="{{ $attachment->file_name }}">{{ $attachment->file_name }}</div>
                                                        <div class="media__description">
                                                            {{ strtoupper(pathinfo($attachment->file_name, PATHINFO_EXTENSION)) }} · {{ $attachment->file_size_formatted }}
                                                        </div>
                                                    </div>
                                                    <div class="media__action">
                                                        <a href="{{ asset('storage/' . $attachment->file_path) }}" download="{{ $attachment->file_name }}"
                                                            class="button button--sm button--outline button--neutral button--icon-only" aria-label="Unduh {{ $attachment->file_name }}">
                                                            <x-icon name="download" />
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Tanggapan --}}
                <div class="card">
                    <div class="card__header">
                        <h3 class="card__title">Tanggapan ({{ $ticket->responses->count() }})</h3>
                    </div>
                    <div class="card__body flex flex-col gap-5">
                        @forelse($ticket->responses as $response)
                            <div class="media items-start {{ $response->is_internal ? 'response--internal' : '' }}">
                                <div class="media__figure">
                                    <x-avatar :name="$response->user->name" />
                                </div>
                                <div class="media__content">
                                    <div class="media__title flex flex-wrap items-center gap-2">
                                        {{ $response->user->name }}
                                        @if($response->is_internal)
                                            <span class="badge badge--soft badge--warning">Internal</span>
                                        @endif
                                    </div>
                                    <div class="media__meta">{{ $response->created_at->format('d/m/Y H:i') }}</div>
                                    <p class="mt-2 whitespace-pre-line">{{ $response->message }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state empty-state--sm">
                                <span class="empty-state__media"><x-icon name="message-square" /></span>
                                <h4 class="empty-state__title">Belum ada tanggapan</h4>
                            </div>
                        @endforelse
                    </div>

                    <div class="card__footer block">
                        <h4 class="font-semibold mb-3">Tambah Tanggapan</h4>
                        <form method="POST" action="{{ route('tickets.addResponse', $ticket) }}" class="flex flex-col gap-3">
                            @csrf
                            <div class="field">
                                <label for="message" class="sr-only">Tanggapan</label>
                                <textarea id="message" name="message" rows="4" class="textarea"
                                    placeholder="Tulis tanggapan Anda..." required></textarea>
                            </div>

                            @if($canManage)
                                <div class="field__item">
                                    <input type="checkbox" id="is_internal" name="is_internal" value="1" class="checkbox">
                                    <label for="is_internal" class="field__label">Catatan internal (tidak terlihat oleh pengguna)</label>
                                </div>
                            @endif

                            <div>
                                <button type="submit" class="button button--primary"><x-icon name="send" /> Kirim Tanggapan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Kolom samping --}}
            <div class="flex flex-col gap-6">
                @if($canManage)
                    <div class="card">
                        <div class="card__header"><h3 class="card__title">Update Status</h3></div>
                        <form method="POST" action="{{ route('tickets.update', $ticket) }}">
                            @csrf
                            @method('PUT')
                            <div class="card__body flex flex-col gap-4">
                                <div class="field">
                                    <label for="status" class="field__label">Status</label>
                                    <select id="status" name="status" class="select">
                                        <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Terbuka</option>
                                        <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                                        <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Terselesaikan</option>
                                        <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Ditutup</option>
                                    </select>
                                </div>
                                <div class="field">
                                    <label for="priority" class="field__label">Prioritas</label>
                                    <select id="priority" name="priority" class="select">
                                        <option value="low" {{ $ticket->priority == 'low' ? 'selected' : '' }}>Rendah</option>
                                        <option value="medium" {{ $ticket->priority == 'medium' ? 'selected' : '' }}>Sedang</option>
                                        <option value="high" {{ $ticket->priority == 'high' ? 'selected' : '' }}>Tinggi</option>
                                        <option value="critical" {{ $ticket->priority == 'critical' ? 'selected' : '' }}>Kritis</option>
                                    </select>
                                </div>
                                <button type="submit" class="button button--primary button--block">Update</button>
                            </div>
                        </form>
                    </div>

                    @if($authUser->isAdmin())
                        <div class="card">
                            <div class="card__header"><h3 class="card__title">Tugaskan Teknisi</h3></div>
                            <form method="POST" action="{{ route('tickets.assign', $ticket) }}">
                                @csrf
                                <div class="card__body flex flex-col gap-4">
                                    <div class="field">
                                        <label for="assigned_to" class="sr-only">Teknisi</label>
                                        <select id="assigned_to" name="assigned_to" class="select">
                                            <option value="">-- Pilih Teknisi --</option>
                                            @foreach($technicians as $tech)
                                                <option value="{{ $tech->id }}" {{ $ticket->assigned_to == $tech->id ? 'selected' : '' }}>
                                                    {{ $tech->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="button button--primary button--block">Tugaskan</button>
                                </div>
                            </form>
                        </div>
                    @endif

                    @if($authUser->isTechnician() && !$ticket->assigned_to)
                        <div class="card">
                            <div class="card__body">
                                <form method="POST" action="{{ route('tickets.assignToSelf', $ticket) }}">
                                    @csrf
                                    <button type="submit" class="button button--primary button--block">
                                        <x-icon name="user-check" /> Ambil Tiket Ini
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endif

                <div class="card">
                    <div class="card__header"><h3 class="card__title">Informasi Tiket</h3></div>
                    <div class="card__body">
                        <div class="kv"><span class="kv__label">Nomor Tiket</span><span class="font-medium">{{ $ticket->ticket_number }}</span></div>
                        <div class="kv"><span class="kv__label">Dibuat</span><span>{{ $ticket->created_at->format('d/m/Y H:i') }}</span></div>
                        @if($ticket->resolved_at)
                            <div class="kv"><span class="kv__label">Diselesaikan</span><span>{{ $ticket->resolved_at->format('d/m/Y H:i') }}</span></div>
                        @endif
                        @if($ticket->closed_at)
                            <div class="kv"><span class="kv__label">Ditutup</span><span>{{ $ticket->closed_at->format('d/m/Y H:i') }}</span></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
