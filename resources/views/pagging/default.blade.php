@if ($paginator->count())
<ul class="pagination pagination-sm no-margin pull-right">
    @if ($paginator->currentPage() > 1)
        <li><a href="{{$paginator->url(1)}}"><span class="fa fa-fw fa-angle-double-left"></span></a></li>
        <li><a href="{{ $paginator->previousPageUrl() }}"><span class="fa fa-fw fa-angle-left"></span></a></li>
    @else
        <li class="disabled"><a href="#"><span class="fa fa-fw fa-angle-double-left"></span></a></li>
        <li class="disabled"><a href="#"><span class="fa fa-fw fa-angle-left"></span></a></li>
    @endif
    @foreach ($elements as $element)
        @if (is_string($element))
            <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="footable-page active"><a data-page="{{ $page }}" href="#">{{ $page }}</a></li>
                @else
                    <li class="footable-page"><a data-page="{{ $page }}" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach
    @if ($paginator->currentPage() < $paginator->total())
        <li><a href="{{ $paginator->nextPageUrl() }}"><span class="fa fa-fw fa-angle-right"></span></a></li>
        <li><a href="{{$paginator->url($paginator->lastPage())}}"><span class="fa fa-fw fa-angle-double-right"></span></a></li>
    @else
        <li class="disabled"><a href="#"><span class="fa fa-fw fa-angle-right"></span></a></li>
        <li class="disabled"><a href="#"><span class="fa fa-fw fa-angle-double-right"></span></a></li>
    @endif
</ul>
@endif