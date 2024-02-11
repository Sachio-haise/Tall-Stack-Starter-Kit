<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Roles') }}
        </h2>
        <x-breadcrumb :main="['name' => 'Dashboard', 'route' => route('dashboard')]" :children="[['name' => 'Roles', 'route' => route('roles.index')]]" />
    </x-slot>

    @if(session()->has('message') && session()->has('style'))
    <x-banner :style="session('style')" :message="session('message')" />
    @endif

    <div class="pb-12 mt-16">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                {{-- For thead --}}
                @section('field')
                <tr>
                    <th scope="col" class="px-2 py-3 text-right">ID</th>
                    <th scope="col" class="px-2 py-3 text-left">NAME</th>
                    <th scope="col" class="px-2 py-3 text-left">guard name</th>
                    @can($respond['allow_permissions']['status'])
                    <th scope="col" class="px-2 py-3 text-left">CREATED</th>
                    <th scope="col" class="px-2 py-3 text-left">UPDATED</th>
                    @endcan
                    <th colspan="2" class="text-center">ACTION</th>
                </tr>
                @endsection

                {{-- For tbody --}}
                @section('contents')
                @if($respond['paginate']->isEmpty())
                <tr class="text-gray-900 bg-white border-b dark:text-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th colspan="7" scope="row" class="px-2 py-4 font-medium text-center whitespace-nowrap">
                        No Data Found
                    </th>
                </tr>
                @else
                @foreach($respond['paginate'] as $item)
                <tr class="{{ isset($item->deleted_at) ? 'text-gray-300' : 'text-gray-900' }} bg-white border-b dark:text-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-2 py-4 w-[40px] font-medium whitespace-nowrap ">
                        <div class="text-right">
                            <div class="text-sm font-semibold text-gray-500">{{ $item->id }}.</div>
                        </div>
                    </th>
                    <th scope="row" class="px-2 py-4 font-medium whitespace-nowrap">{{ $item->name }}</th>
                    <th scope="row" class="px-2 py-4 font-medium whitespace-nowrap">{{ $item->guard_name }}</th>

                    {{-- CREATED --}}
                    @can($respond['allow_permissions']['status'])
                    <th scope="row" class="px-2 py-4 w-[70px] font-medium whitespace-nowrap ">
                        <div class="text-left">
                            <div class="text-xs text-gray-400">{!! Helper::gethumanTime($item->created_at) !!}</div>
                            @if($item->created_by)
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ Str::upper($item->createdBy->name ?? '-') }}</span>
                            @endif
                        </div>
                    </th>
                    @endcan
                    {{-- UPDATED --}}
                    @can($respond['allow_permissions']['status'])
                    <th scope="row" class="px-2 py-4 w-[70px] font-medium whitespace-nowrap ">
                        <div class="text-left">
                            <div class="text-xs text-gray-400">{!! Helper::gethumanTime($item->created_at) !!}</div>
                            @if($item->updated_by)
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ Str::upper($item->updatedBy->name ?? '-') }}</span>
                            @endif
                        </div>
                    </th>
                    @endcan
                    {{-- ACTION --}}
                    <th scope="row" class="px-2 py-4 w-[50px] font-light whitespace-nowrap">
                        @can($respond['allow_permissions']['edit'])
                        @if($item->name !== "super-admin")
                        @php
                        $edit = App\Http\Helpers\FormHelper::getEdit('roles', $item->id)
                        @endphp
                        {!! $edit !!}
                        @else
                        <a href="#" class="text-gray-500 cursor-not-allowed opacity-30">Edit</a>
                        @endif
                        @else
                        <a href="#" class="text-gray-500 cursor-not-allowed opacity-30">Edit</a>
                        @endcan
                    </th>
                    <th scope="row" class="px-2 py-4 w-[50px] font-medium  whitespace-nowrap">
                        @can($respond['allow_permissions']['delete'])
                        @if($item->name !== "super-admin")
                        @php
                        $delete = App\Http\Helpers\FormHelper::getDestroy('roles', $item->id)
                        @endphp
                        {!! $delete !!}
                        @else
                        <a href="#" class="text-gray-500 cursor-not-allowed opacity-30">Delete</a>
                        @endif
                        @else
                        <a href="#" class="text-gray-500 cursor-not-allowed opacity-30">Delete</a>
                        @endcan
                    </th>
                </tr>
                @endforeach
                @endif
                @endsection
                <x-table :create_url="route('roles.create')" :search_url="route('roles.search')" :title="__('Role')" :paginate="$respond['paginate']" :search="$respond['search']" :allow_permission="$respond['allow_permissions']" />
            </div>
        </div>
    </div>

</x-app-layout>
