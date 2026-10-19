{{-- Pagination memakai komponen .pagination Stisla. Didaftarkan sebagai default di AppServiceProvider. --}}
@if ($paginator->hasPages())
    <nav class="flex flex-wrap items-center justify-between gap-3" role="navigation" aria-label="Pagination">
        <span class="text-xs text-muted-foreground">
            Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }}
        </span>

        <ul class="pagination">
            {{-- Sebelumnya --}}
            <li>
                @if ($paginator->onFirstPage())
                    <span class="pagination__button" aria-disabled="true" aria-label="Sebelumnya"><x-icon name="arrow-left" /></span>
                @else
                    <a class="pagination__button" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya"><x-icon name="arrow-left" /></a>
                @endif
            </li>

            {{-- Nomor halaman --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="pagination__ellipsis">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            @if ($page == $paginator->currentPage())
                                <span class="pagination__button" data-state="active" aria-current="page">{{ $page }}</span>
                            @else
                                <a class="pagination__button" href="{{ $url }}" aria-label="Ke halaman {{ $page }}">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach

            {{-- Berikutnya --}}
            <li>
                @if ($paginator->hasMorePages())
                    <a class="pagination__button" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya"><x-icon name="arrow-right" /></a>
                @else
                    <span class="pagination__button" aria-disabled="true" aria-label="Berikutnya"><x-icon name="arrow-right" /></span>
                @endif
            </li>
        </ul>
    </nav>
@endif
