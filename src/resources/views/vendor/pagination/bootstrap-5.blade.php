@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between">
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.previous')</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.next')</span>
                    </li>
                @endif
            </ul>
        </div>

        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-end py-2">
            <div class="me-5">
                <p class="small mb-0">
                    <span class="fw-bold">{{ $paginator->total() }} people in the list</span>
                </p>
            </div>

            <div>
                <div class="pagination fw-bold">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span class="page-link" aria-hidden="true">←</span>
                        </span>
                    @else
                        <span class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">←</a>
                        </span>
                    @endif

                    <div class="mx-2 d-flex align-items-center">
                        <p class="small mb-0">
                            <span class="">{{ $paginator->firstItem() }}</span>
                             - 
                            <span class="">{{ $paginator->lastItem() }}</span>
                            <span class="fw-normal">{!! __('of') !!}</span>
                            <span class="">{{ round($paginator->total()/$paginator->perPage()) }}</span>
                        </p>
                    </div>
                    {{-- Pagination Elements --}}
                    {{-- @foreach ($elements as $element) --}}
                        {{-- "Three Dots" Separator --}}
                        {{-- @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                        @endif --}}

                        {{-- Array Of Links --}}
                        {{-- @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach --}}

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <span class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">→</a>
                        </span>
                    @else
                        <span class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                            <span class="page-link" aria-hidden="true">→</span>
                        </span>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif
