@if ($paginator->hasPages())
    <div class="columns is-hidden-mobile">
        <div class="column is-6 is-offset-3">
            <nav class="pagination is-centered">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="is-disabled pagination-previous">
                <span class="icon">
                    <i class="fa fa-step-backward"></i>
                </span>
            </span>
                    <span class="is-disabled pagination-previous">
                <span class="icon">
                    <i class="fa fa-backward"></i>
                </span>
            </span>
                @else

                    <a class="pagination-previous" href="?page=1">
                <span class="icon">
                    <i class="fa fa-step-backward"></i>
                </span>
                    </a>

                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-previous">
                    <span class="icon">
                        <i class="fa fa-backward"></i>
                    </span>
                    </a>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-next">
                <span class="icon">
                    <i class="fa fa-forward"></i>
                </span>
                    </a>

                    <a class="pagination-next" href="?page={{ $paginator->lastPage() }}">
                <span class="icon">
                    <i class="fa fa-step-forward"></i>
                </span>
                    </a>
                @else
                    <span class="is-disabled pagination-next"><span class="icon">
                    <i class="fa fa-forward"></i>
                </span>
            </span>

                    <span class="is-disabled pagination-next">
                <span class="icon">
                    <i class="fa fa-step-forward"></i>
                </span>
            </span>
                @endif

                <ul class="pagination-list">

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="is-disabled"><span>{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="is-current pagination-link"><span>{{ $page }}</span></li>
                                @else
                                    <a href="{{ $url }}">
                                        <li class="pagination-link">{{ $page }}</li>
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                </ul>

            </nav>
        </div>
    </div>

        <nav class="pagination is-centered is-hidden-tablet">

            <div class="columns">
                <div class="column">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span class="is-disabled pagination-previous">
                            <span class="icon">
                                <i class="fa fa-step-backward"></i>
                            </span>
                        </span>

                        <span class="is-disabled pagination-previous">
                            <span class="icon">
                                <i class="fa fa-backward"></i>
                            </span>
                        </span>
                    @else

                        <a class="pagination-previous" href="?page=1">
                            <span class="icon">
                                <i class="fa fa-step-backward"></i>
                            </span>
                        </a>

                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-previous">
                            <span class="icon">
                                <i class="fa fa-backward"></i>
                            </span>
                        </a>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-next">
                            <span class="icon">
                                <i class="fa fa-forward"></i>
                            </span>
                        </a>

                        <a class="pagination-next" href="?page={{ $paginator->lastPage() }}">
                            <span class="icon">
                                <i class="fa fa-step-forward"></i>
                            </span>
                        </a>
                    @else
                        <span class="is-disabled pagination-next">
                            <span class="icon">
                                <i class="fa fa-forward"></i>
                             </span>
                        </span>

                        <span class="is-disabled pagination-next">
                            <span class="icon">
                                <i class="fa fa-step-forward"></i>
                            </span>
                         </span>
                    @endif
                </div>

                <div class="column ">
                    <ul class="pagination-list">

                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <li class="is-disabled"><span>{{ $element }}</span></li>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        <li class="is-current pagination-link"><span>{{ $page }}</span></li>
                                    @else
                                        <a href="{{ $url }}">
                                            <li class="pagination-link">{{ $page }}</li>
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                    </ul>
                </div>
            </div>

        </nav>
@endif
