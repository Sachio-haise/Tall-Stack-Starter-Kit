<div>
    <div class="m-auto w-[50%] items-center justify-evenly py-2 md:flex">
        @if ($is_search_show)
        <div class="inset-y-0 right-0 mt-4 flex items-center lg:mt-0">
            <label class="ml-2 flex text-sm font-medium text-gray-900 dark:text-gray-300" for="include_deleted">
                Show&nbsp;
            </label>
            <select class="block w-[100px] rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500" wire:model.lazy="limit">
                <option value="10">10 Nos</option>
                <option value="20">20 Nos</option>
                <option value="50">50 Nos</option>
                <option value="100">100 Nos</option>
            </select>
        </div>
        @endif

        @if ($is_search_period)
        <div class="inset-y-0 right-0 mt-4 flex items-center lg:mt-0">
            <label class="ml-2 flex text-sm font-medium text-gray-900 dark:text-gray-300" for="include_deleted">
                Period&nbsp;
            </label>
            <select class="block w-[130px] rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500" wire:model.lazy="duration">
                <option value="">Please select</option>
                <option value="today">Today</option>
                <option value="this weeks">This Weeks</option>
                <option value="this month">This Months</option>
                <option value="this year">This Years</option>
            </select>
        </div>
        @else
        @livewire($is_search_component)
        @endif

        <div class="ml-3">
            <label class="sr-only" for="table-search">Search</label>
            <div class="relative">
                <div class="pointer-events-none absolute bottom-9 left-0 top-5 flex items-center pl-3 lg:bottom-0 lg:top-0">
                    <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input class="block w-[200px] rounded-lg border border-gray-300 bg-gray-50 p-2 pl-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500" id="table-search" name="search" type="text" value="{{ $search ?? '' }}" wire:model.live='search' placeholder="Search...">
            </div>
        </div>

       @if ($is_deleted_show)
        <div class="inset-y-0 right-0 mt-4 flex items-center lg:mt-0">
            <label class="ml-2 flex text-sm font-medium text-gray-900 dark:text-gray-300" for="include_deleted">
                <svg class="h-[16px] w-[16px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z" />
                </svg>
            </label>
            <input class="ml-2 h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600" id="include_deleted" type="checkbox" value="1" wire:model.lazy="include_deleted">
        </div>
       @endif
    </div>
</div>
