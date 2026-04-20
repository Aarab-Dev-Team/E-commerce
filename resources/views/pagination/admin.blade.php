@if ($paginator->hasPages())
    <div class="pagination">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="page-num disabled"><i class="iconoir-nav-arrow-left"></i></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-num"><i class="iconoir-nav-arrow-left"></i></a>
        @endif

        {{-- Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="page-num">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-num active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-num">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-num"><i class="iconoir-nav-arrow-right"></i></a>
        @else
            <span class="page-num disabled"><i class="iconoir-nav-arrow-right"></i></span>
        @endif
    </div>
@endif