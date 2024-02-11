<div>
    <div class="mx-auto max-w-[90rem] px-2 py-2 sm:px-6">
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-y-auto">
                <div class="inline-block min-w-full p-1.5 align-middle">
                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-slate-900">

                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-slate-800">
                                @yield('field')
                            </thead>
                            <tbody>
                                @yield('contents')
                            </tbody>
                        </table>
                        <div class="grid grid-cols-1 gap-4 bg-gray-200 bg-opacity-25 px-6 py-1 md:grid-cols-1">
                            <nav class="items-start">
                                @yield('paginate')
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
