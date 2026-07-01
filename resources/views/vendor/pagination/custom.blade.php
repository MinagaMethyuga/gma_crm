@if ($paginator->hasPages())
    <div class="flex items-center justify-between">
        <div class="text-[13px] text-slate-500 font-medium">
            Showing <span class="font-bold text-slate-700">{{ $paginator->firstItem() }}</span> to <span class="font-bold text-slate-700">{{ $paginator->lastItem() }}</span> of <span class="font-bold text-slate-700">{{ $paginator->total() }}</span> members
        </div>
        <div class="flex items-center gap-1.5">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <button disabled class="w-8 h-8 flex items-center justify-center text-slate-300 rounded-md cursor-not-allowed">
                    <span class="material-symbols-outlined text-lg">chevron_left</span>
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-slate-600 rounded-md transition-colors">
                    <span class="material-symbols-outlined text-lg">chevron_left</span>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="w-8 h-8 flex items-center justify-center text-slate-400 font-bold text-sm">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <button class="w-8 h-8 flex items-center justify-center bg-[#4338ca] text-white font-bold text-sm rounded-md shadow-sm">
                                {{ $page }}
                            </button>
                        @else
                            <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center hover:bg-slate-200 text-slate-600 font-bold text-sm rounded-md transition-colors">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center text-slate-500 hover:text-slate-700 rounded-md transition-colors">
                    <span class="material-symbols-outlined text-lg">chevron_right</span>
                </a>
            @else
                <button disabled class="w-8 h-8 flex items-center justify-center text-slate-300 rounded-md cursor-not-allowed">
                    <span class="material-symbols-outlined text-lg">chevron_right</span>
                </button>
            @endif
        </div>
    </div>
@else
    <div class="text-[13px] text-slate-500 font-medium">
        Showing <span class="font-bold text-slate-700">{{ $paginator->count() }}</span> of <span class="font-bold text-slate-700">{{ $paginator->count() }}</span> members
    </div>
@endif
