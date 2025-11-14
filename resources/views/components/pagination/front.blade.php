@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="pagination-front">
        <div class="hidden text-xs font-semibold uppercase tracking-[0.25em] text-slate-500 sm:block">
            Pagina {{ $paginator->currentPage() }} de {{ $paginator->lastPage() }}
        </div>

        <div class="inline-flex items-center gap-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="pagination-front__button disabled">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M15 6l-6 6 6 6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-front__button" aria-label="{{ __('pagination.previous') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M15 6l-6 6 6 6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="pagination-front__item disabled">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pagination-front__item active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-front__item">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-front__button" aria-label="{{ __('pagination.next') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M9 6l6 6-6 6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            @else
                <span class="pagination-front__button disabled">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M9 6l6 6-6 6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif
