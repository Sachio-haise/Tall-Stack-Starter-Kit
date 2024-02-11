<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Roles') }}
        </h2>
        <x-breadcrumb :main="['name' => 'Dashboard', 'route' => route('dashboard')]" :children="[['name' => 'Roles', 'route' => route('roles.index')],['name' => 'Edit', 'route' => route('roles.edit', $roles['id'])]]" />
    </x-slot>
    <div class="py-5">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <form action='{{ route('roles.update', $roles['id']) }}' method="POST">
                <div class="p-6 bg-white rounded-lg shadow-md">
                    @csrf
                    @method('put')
                    <div class="grid grid-col-3">
                        <div class="flex-1 m-3">
                            <x-label for="name" class="block mb-2 text-sm font-medium text-gray-700" value="{{ __('Role Name') }}" />
                            <x-input type="text" id="name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" name="name" placeholder="" :value="$roles['name']" />
                            @error('name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex-1 m-3">
                            <p>Enable all Permissions currently Enabled for this role</p>
                            <label class="relative inline-flex items-center mt-3 cursor-pointer">
                                <input type="checkbox" id="root" class="sr-only peer">
                                <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Select All</span>
                            </label>
                            <x-button class="float-right">Update Role</x-button>
                        </div>
                    </div>

                    <hr class="h-px mx-3 bg-gray-200 border-0 dark:bg-gray-700">
                    <div class="grid grid-cols-2 gap-2 overflow-hidden lg:grid-cols-6 sm:grid-cols-4">
                        @foreach ($permissions as $title => $permission)
                        <div class="m-3 overflow-hidden">
                            <fieldset class="p-4 border border-gray-300 shadow-sm rounded-xl dark:border-gray-600 dark:text-dark-200 text-primary-600">
                                <legend class="px-2 -ml-2 text-sm font-medium leading-tight">{{ Str::ucfirst($title)}}</legend>
                                <div class="grid grid-cols-1 gap-2">
                                    @foreach ($permission as $name => $value)
                                    <label class="relative inline-flex items-center mr-5 cursor-pointer">
                                        <input type="checkbox" name="permission[]" value="{{$value}}" class="sr-only peer" @checked(Helper::getPermission($roles->permissions, $value))>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-yellow-600"></div>
                                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{$name}}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>
                        @endforeach
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById("root").addEventListener("change", function() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"][name="permission[]"]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = this.checked;
            }
        });
    </script>
</x-app-layout>
