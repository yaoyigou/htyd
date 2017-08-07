{!! $html1 or '' !!}
@if ($paginator->hasPages())
    {!! $html2 or '' !!}
    @push('header')
    <link href="{{path('css/common/page.css')}}" rel="stylesheet" type="text/css"/>
    @endpush
    <div class="fenye" style="text-align: right;">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">上一页</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}"
                                         rel="prev">上一页</a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $k=>$element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">下一页</a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link">下一页</span></li>
            @endif
            <li class="page-item"><span class="page-link no-border"
                                        style="padding-right: 0 !important;">共{{$paginator->lastPage()}}
                    页</span></li>
            @if(isset($show_form)&&$show_form==1)
                <li class="page-item"><span class="page-link no-border">到第</span></li>
                <form style="display: inline-block;" action="{{$action}}" id="page_form">
                    @foreach($inputs as $k=>$v)
                        @if($k!='page')
                            <input type="hidden" name="{{$k}}" value="{{$v}}"/>
                        @endif
                    @endforeach
                </form>
                <li class="page-item"><span class="page-link">
                            <input form="page_form" style="margin-top: -1px;width: 20px;text-align: center;" type="text"
                                   name="page"
                                   value="{{$paginator->currentPage()}}"/>
                        </span></li>
                <li class="page-item"><span class="page-link no-border">页</span></li>
                <li class="page-item">
                    <button style="cursor: pointer" form="page_form" type="submit" class="page-link">确定</button>
                </li>
            @endif
        </ul>
    </div>
@endif
