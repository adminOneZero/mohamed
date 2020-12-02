@if ($paginator->hasPages())
<div class="col-12 text-center but-num">

    <ul class="pager">
       
        
        @if ($paginator->hasMorePages())
            <li><a  href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fas fa-chevron-right"></i></a></li>
        @else
            <li><i class="fas fa-chevron-right"></i></li>
        @endif
        
        @foreach ($elements as $element)
        
            @if (is_string($element))
            <li class="disabled"><span>{{ $element }}</span></li>
            @endif
            
            @if (is_array($element))
                @foreach (\array_reverse($element,true) as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li style="color:blue;" class="active my-active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif

        @endforeach
        
        
        @if ($paginator->onFirstPage())
            <li><i class="fas fa-chevron-left"></i></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fas fa-chevron-left"></i></a></li>
        @endif

        
    </ul>    
</div>    

@endif 