{{-- resources/views/components/vietnamese-pagination.blade.php --}}
@if ($paginator->hasPages())
    <div class="flex flex-col items-center space-y-4">
        {{-- Results Info --}}
        @if ($paginator->total() > 0)
            <div class="text-sm text-gray-600">
                <strong class="text-[#1c1c1c]">{{ $paginator->lastItem() }}/</strong><strong class="text-[#1c1c1c]">{{ $paginator->total() }}</strong> kết quả
            </div>
        @endif

        {{-- Navigation Links --}}
        <nav class="flex items-center space-x-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                    <i class="fas fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}#grid"
                   class="px-4 py-2 text-[#1c1c1c] bg-white rounded-lg hover:bg-[#1c1c1c] hover:text-white transition-all duration-300">
                    <i class="fas fa-chevron-left"></i>
                </a>
            @endif

            {{-- Page Numbers --}}
            @php
                $start = max(1, $paginator->currentPage() - 2);
                $end = min($paginator->lastPage(), $paginator->currentPage() + 2);
            @endphp

            {{-- First Page --}}
            @if($start > 1)
                <a href="{{ $paginator->url(1) }}#grid"
                   class="px-4 py-2 text-gray-700 bg-white rounded-lg hover:bg-[#1c1c1c] hover:text-white transition-all duration-300">
                    1
                </a>
                @if($start > 2)
                    <span class="px-4 py-2 text-gray-400">...</span>
                @endif
            @endif

            {{-- Page Numbers --}}
            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $paginator->currentPage())
                    <span class="px-4 py-2 text-white bg-[#1c1c1c] rounded-lg font-semibold">
                        {{ $i }}
                    </span>
                @else
                    <a href="{{ $paginator->url($i) }}#grid"
                       class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-[#1c1c1c] hover:text-white transition-all duration-300">
                        {{ $i }}
                    </a>
                @endif
            @endfor

            {{-- Last Page --}}
            @if($end < $paginator->lastPage())
                @if($end < $paginator->lastPage() - 1)
                    <span class="px-4 py-2 text-gray-400">...</span>
                @endif
                <a href="{{ $paginator->url($paginator->lastPage()) }}#grid"
                   class="px-4 py-2 text-gray-700 bg-white rounded-lg hover:bg-[#1c1c1c] hover:text-white transition-all duration-300">
                    {{ $paginator->lastPage() }}
                </a>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}#grid"
                   class="px-4 py-2 text-[#1c1c1c] bg-white rounded-lg hover:bg-[#1c1c1c] hover:text-white transition-all duration-300">
                    <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                    <i class="fas fa-chevron-right"></i>
                </span>
            @endif
        </nav>
    </div>
@endif

