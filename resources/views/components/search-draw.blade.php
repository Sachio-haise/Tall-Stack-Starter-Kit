@props([
'is_search_period',
'is_search_show',
'is_search_component',
])
<div>
    <div class="fixed left-0 right-0 top-0 z-40 mx-auto max-w-2xl -translate-y-full bg-white transition-transform dark:bg-gray-800 sm:px-6 lg:px-8 rounded-lg" id="drawer-top-example" aria-labelledby="drawer-top-label" tabindex="-1">
        <div class="mx-auto py-2">
            <livewire:search-form :is_search_period="$is_search_period" :is_search_show="$is_search_show" :is_search_component="$is_search_component" />
        </div>

        <button class="absolute end-2.5 top-5 inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white" data-drawer-hide="drawer-top-example" type="button" aria-controls="drawer-top-example">
            <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close menu</span>
        </button>

        <div class="h-fit sm:justify-end md:mt-0 md:items-center">
            {{ $slot }}
        </div>
    </div>
</div>
