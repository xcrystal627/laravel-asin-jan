<?php 
    $currentUrl = url()->current();
    $_type = 'updated_at';
    $_sort = 'asc';
    if(strpos($currentUrl, "item_list") == true ) {
        $_type = $type;
        if($sort == 'asc') {
            $_sort = 'desc';
        } else {
            $_sort = 'asc';
        }
    } 
    
?>

@if ($paginator->hasPages())
    <div class="pagination-container justify-content-center mb-4">
        <ul class="pagination pagination-info justify-content-center">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" href="javascript:;" aria-label="Previous">
                        <span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl()}}&type={{$_type}}&sort={{$_sort}}" aria-label="Previous">
                        <span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)

                @if (is_string($element))
                    <li class="page-item disabled">
                        <a class="page-link" href="javascript:;">{{ $element }}</a>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <a class="page-link" href="javascript:;">{{ $page }}</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}&type={{$_type}}&sort={{$_sort}}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}&type={{$_type}}&sort={{$_sort}}" aria-label="Next">
                        <span aria-hidden="true"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link" href="javascript:;" aria-label="Next">
                        <span aria-hidden="true"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
@endif
