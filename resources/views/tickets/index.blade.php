@extends('layouts.app')

@section('title', 'Daftar Tiket')

@section('content')
    @php($isUser = auth()->user()->isUser())

    <x-page-header title="Daftar Tiket" description="Kelola dan pantau semua tiket support">
        @if($isUser)
            <x-slot:actions>
                <a href="{{ route('tickets.create') }}" class="button button--primary">
                    <x-icon name="plus" /> Buat Tiket Baru
                </a>
            </x-slot:actions>
        @endif
    </x-page-header>

    <div class="page__body">
        <div class="card">
            <div class="table-responsive">
                <table class="table table--hover table--align-middle">
                    <thead class="table__head--alt">
                        <tr>
                            <th scope="col">No. Tiket</th>
                            <th scope="col">Judul</th>
                            @unless($isUser)<th scope="col">Pengguna</th>@endunless
                            <th scope="col">Kategori</th>
                            <th scope="col">Prioritas</th>
                            <th scope="col">Status</th>
                            @unless($isUser)<th scope="col">Ditugaskan</th>@endunless
                            <th scope="col">Dibuat</th>
                            <th scope="col" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td class="whitespace-nowrap">
                                    <a href="{{ route('tickets.show', $ticket) }}" class="link font-medium">{{ $ticket->ticket_number }}</a>
                                </td>
                                <td class="font-medium">{{ Str::limit($ticket->title, 50) }}</td>
                                @unless($isUser)
                                    <td class="whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <x-avatar :name="$ticket->user->name" />
                                            <span>{{ $ticket->user->name }}</span>
                                        </div>
                                    </td>
                                @endunless
                                <td class="whitespace-nowrap">{{ $ticket->category->icon }} {{ $ticket->category->name }}</td>
                                <td><x-priority-badge :ticket="$ticket" /></td>
                                <td><x-status-badge :ticket="$ticket" /></td>
                                @unless($isUser)
                                    <td class="whitespace-nowrap">
                                        @if($ticket->assignedTo)
                                            <div class="flex items-center gap-2">
                                                <x-avatar :name="$ticket->assignedTo->name" />
                                                <span>{{ $ticket->assignedTo->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted-foreground italic">Belum ditugaskan</span>
                                        @endif
                                    </td>
                                @endunless
                                <td class="whitespace-nowrap text-muted-foreground">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('tickets.show', $ticket) }}" class="button button--sm button--outline button--neutral">Lihat</a>
                                </td>
                            </tr>
                        @empty
                            <x-empty-row :colspan="$isUser ? 7 : 9" icon="ticket" title="Belum ada tiket">
                                @if($isUser)
                                    <a href="{{ route('tickets.create') }}" class="button button--primary button--sm">Buat Tiket Pertama</a>
                                @endif
                            </x-empty-row>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($tickets->hasPages())
                <div class="card__footer">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
