@props([
'title' => __('Title'),
'breadcrumbs' => [],
'is_search' => false,
'is_search_period',
'is_search_show',
'is_search_component'
])

<div>
    <div class="grid w-full grid-cols-3 gap-5">
        <div class="w-[20%]">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __($title) }}
            </h2>
            <nav class="flex mt-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 rtl:space-x-reverse md:space-x-2">
                    <li class="inline-flex items-center">
                        <a class="inline-flex items-center text-sm font-light text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white" href="{{ route('dashboard') }}">
                            <svg class="me-2.5 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            {{ 'Dashboard' }}
                        </a>
                    </li>
                    @foreach ($breadcrumbs as $current)
                    <li>
                        <div class="flex items-center whitespace-nowrap">
                            <svg class="h-3 w-3 text-gray-400 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <a class="ms-1 text-sm font-light text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white md:ms-2" href="{{ $current['route'] }}">{{ $current['name'] }}</a>
                        </div>
                    </li>
                    @endforeach
                </ol>
            </nav>
        </div>

        <div class="flex w-full justify-center gap-3">
            @yield('widgets')
        </div>

        <div class="flex w-full justify-end gap-3">
            <div class="flex items-center text-center">
                @if ($is_search)
                <button class="" id="openModalButton" data-drawer-target="drawer-top-example" data-drawer-show="drawer-top-example" data-drawer-placement="top" type="button" aria-controls="drawer-top-example">
                    <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </button>

                {{-- Create button --}}
                <x-search-draw :is_search_show="$is_search_show" :is_search_period="$is_search_period" :is_search_component="$is_search_component">
                </x-search-draw>
                @endif

                <div class="ml-2">
                    {{-- Create button --}}
                    @yield('create')
                </div>
            </div>
        </div>
    </div>
</div>
