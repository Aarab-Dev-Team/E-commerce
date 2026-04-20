@if ($paginator->hasPages())
    <div class="pagination">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="page-link disabled"><i class="iconoir-nav-arrow-left"></i></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-link"><i class="iconoir-nav-arrow-left"></i></a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="page-link disabled">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-link active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-link"><i class="iconoir-nav-arrow-right"></i></a>
        @else
            <span class="page-link disabled"><i class="iconoir-nav-arrow-right"></i></span>
        @endif
    </div>
@endif