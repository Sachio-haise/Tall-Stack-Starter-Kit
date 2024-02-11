@props([
'paginate',
])

<div class="p-6 bg-white border-gray-200 lg:px-8 lg:py-1">
    <div class="grid grid-cols-1 gap-4 px-1 py-2 md:grid-cols-1 text-left">
        <nav class="items-start p-2">
            @if (count($paginate) > 1)
            <p class="text-sm">Total <span class="text-dark-500 font-bold">{{ $paginate->total() }}</span> results
            </p>
            @endif
        </nav>
    </div>

    <div class="relative w-full overflow-x-auto sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                @yield('field')
            </thead>
            <tbody>
                @yield('contents')
            </tbody>
        </table>
    </div>
</div>

<div class="grid grid-cols-1 gap-4 px-8 py-3 bg-gray-100 bg-opacity-25 md:grid-cols-1">
    <nav class="items-start p-2">
        {{ $paginate->links() }}
    </nav>
</div>
