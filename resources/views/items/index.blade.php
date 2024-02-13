<x-app-layout>
    <x-slot name="header">
        <div class="w-full">
            @section('create')
            @can($permission['create'])
            <x-link class="inline-flex items-center rounded-md border border-transparent bg-black px-1 py-1 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-900 hover:text-white focus:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white" href="{{ route('items.create') }}">
                {{ __('Create') }}
            </x-link>
            @endcan
            @endsection

            <x-breadcrumb :title="$title" :breadcrumbs="$breadcrumbs" :is_search="true" :is_search_period="true" :is_search_component="false" :is_search_show="true" :is_deleted_show="true" />
        </div>
    </x-slot>

    @if (session()->has('message') && session()->has('style'))
    <x-banner :style="session('style')" :message="session('message')" />
    @endif
    <div>
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-2">
            <livewire:item.index :permission="$permission" :live_permission="$livePermission" :breadcrumbs="$breadcrumbs" :title="$title" :is_search="true" />
        </div>
    </div>
</x-app-layout>
