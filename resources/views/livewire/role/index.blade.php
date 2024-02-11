<div>
    <div class="sm:flex justify-center lg:hidden md:hidden flex w-full gap-3">
        <button data-tooltip-target="tooltip-animation" class="inline-flex items-center rounded-md border border-gray-200 bg-white px-3 py-0 text-center text-sm font-normal text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-800 dark:focus:ring-gray-700">
            <div class="flex flex-col items-center justify-center">
                <dt class="text-1xl font-extrabold flex items-center justify-center">
                    <svg class="me-2 w-3 h-3 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 19 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 9.376v.786l8 3.925 8-3.925v-.786M1.994 14.191v.786l8 3.925 8-3.925v-.786M10 1.422 2 5.347l8 3.925 8-3.925-8-3.925Z" />
                    </svg>
                    {{ $human_count ?? 0 }}
                </dt>
                <dd class="items-center justify-center text-gray-500 dark:text-gray-400">
                    Roles
                </dd>
            </div>
            </svg>
        </button>

        <div id="tooltip-animation" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
            {{ $total ?? 0 }}
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
    </div>
    @section('field')

    <tr>
        <th class="py-1 ps-6 text-start" scope="col">
            <div class="flex items-center gap-x-2">
                <span class="flex text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                    ID <svg class="-mr-0.5 h-4 w-4 cursor-pointer md:ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" wire:click="sortBy('id')">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                    </svg>
                </span>
            </div>
        </th>
        <th class="py-1 pe-3 text-start" scope="col">
            <div class="flex items-center gap-x-2">
                <span class="flex text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                    information <svg class="-mr-0.5 h-4 w-4 cursor-pointer md:ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" wire:click="sortBy('name')">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                    </svg>
                </span>
            </div>
        </th>
        @if (!$super_admin && in_array('roles_status', $livePermission))
        <th class="px-6 py-1 text-start" scope="col">
            <div class="flex items-center gap-x-2">
                <span class="flex items-center justify-center text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                    Created
                </span>
            </div>
        </th>
        <th class="px-6 py-1 text-start" scope="col">
            <div class="flex items-center gap-x-2">
                <span class="flex items-center justify-center text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                    Updated
                </span>
            </div>
        </th>
        @endif
        <th class="px-3 py-1 text-start" scope="col">
            <div class="flex justify-end px-6 py-1.5">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                    Action
                </span>
            </div>
        </th>
    </tr>
    @endsection

    @section('contents')
    @forelse ($lists as $item)
    <tr class="{{ isset($item->deleted_at) ? 'text-gray-300' : 'text-gray-900' }} border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-600" :key="{{ $item->id }}">
        <td class="h-px w-px whitespace-nowrap px-3 py-2">
            <button class="flex items-center gap-x-2" type="button">&nbsp;&nbsp;
                <span class="text-sm dark:text-gray-200">{{ $item->id }}.</span>
            </button>
        </td>
        <td class="h-px w-px whitespace-nowrap">
            <div class="py-2 pe-6">
                <a class="text-sm dark:text-gray-400" href="#">{{ $item->name }}</a>
            </div>
        </td>

        {{-- CREATED --}}
        @if (!$super_admin && in_array('roles_status', $livePermission))
        <th class="w-[70px] whitespace-nowrap px-2 py-4 font-medium" scope="row">
            <div class="text-left">
                <div class="text-xs">{!! Helper::gethumanTime($item->created_at) !!}</div>
                @if ($item->created_by)
                <span class="mr-2 rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">{{ Str::upper($item->createdBy->name ?? '-') }}</span>
                @endif
            </div>
        </th>

        {{-- UPDATED --}}
        <th class="w-[70px] whitespace-nowrap px-2 py-4 font-medium" scope="row">
            <div class="text-left">
                <div class="text-xs">{!! Helper::gethumanTime($item->created_at) !!}</div>
                @if ($item->updated_by)
                <span class="mr-2 rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">{{ Str::upper($item->updatedBy->name ?? '-') }}</span>
                @endif
            </div>
        </th>
        @endif

        {{-- ACTION --}}
        <td class="h-px w-px whitespace-nowrap">
            <div class="flex justify-end px-6 py-1.5">
                @if ($item->deleted_at)
                @if (in_array('role_restore', $livePermission) || $super_admin)
                @php
                $restore = App\Http\Helpers\FormHelper::getRestore('role', $item->id);
                @endphp
                {!! $restore !!}
                @else
                <a class="inline-flex items-center gap-x-1 text-sm font-light text-teal-600 decoration-2 hover:underline dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#">Restore</a>
                @endif
                @else
                @if (in_array('roles_edit', $livePermission) || $super_admin)
                @php
                $edit = App\Http\Helpers\FormHelper::getEdit('roles', $item->id);
                @endphp
                {!! $edit !!}
                @else
                <a class="cursor-not-allowed text-gray-500 opacity-30" href="#">Edit</a>
                @endif
                @endif
                &nbsp;
                @if (in_array('roles_delete', $livePermission) || $super_admin)
                <form id="deleteForm{{ $item->id }}" style="display: none;" action="{{ route('roles.destroy', $item->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                </form>
                <button class="inline-flex items-center gap-x-1 text-sm font-light text-red-600 decoration-2 hover:underline dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" onClick="showDeleteConfirmation({{ $item->id }})">
                    Delete
                </button>
                @else
                <a class="inline-flex cursor-not-allowed items-center gap-x-1 text-sm font-light text-gray-500 decoration-2 opacity-30 hover:underline dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#">Delete</a>
                @endif
            </div>
        </td>
    </tr>
    @empty
    <tr class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-600">
        <td class="whitespace-nowrap px-1 py-2 text-center font-light" colspan="7" scope="row">
            <span class="text-sm text-gray-600">No Data Found!</span>
        </td>
    </tr>
    @endforelse
    @endsection

    @section('paginate')
    {{ $lists->onEachSide(1)->links() }}
    @if($lists->total() <= 10) <span class="bg-gray-100 bg-opacity-25 py-2 md:grid-cols-1 text-gray-500 text-sm">{{ $lists->total() }} Results</span>
        @endif
        @endsection

        <x-live-table :permission="$permission" :breadcrumbs="$breadcrumbs" :title="$title" :is_search="$is_search" />

        <script>
            function showDeleteConfirmation($id) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to delete this record!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#31C48D",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("deleteForm" + $id).submit();
                    }
                });
            }
        </script>
</div>
