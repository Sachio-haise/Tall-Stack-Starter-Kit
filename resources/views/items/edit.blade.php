<x-app-layout>
    <x-slot name="header">
        <div class="w-full">
            <x-breadcrumb :title="'Items'" :breadcrumbs="$breadcrumbs" :permission="$permission" />
        </div>
    </x-slot>

    @if (session()->has('message') && session()->has('style'))
    <x-banner :style="session('style')" :message="session('message')" />
    @endif

    <div class="py-5">
        <div class="mx-auto max-w-xl sm:px-6 lg:px-8">
            <form class="h-adr" action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    @csrf
                    @method('put')
                    <div class="grid gap-4 bg-white px-6 pt-4 grid-cols-1">
                        <div>
                            <div class="mb-4">
                                <x-label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="name" value="{{ __('Name') }}" />
                                <x-input class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400" id="name" name="name" type="text" value="{{$item->name}}" />
                                @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <div class="mb-4">
                                <x-label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="description" value="{{ __('Description') }}" />
                                <x-input class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400" id="description" name="description" type="text" value="{{$item->description}}" />
                                @error('description')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <div class="mb-4">
                                <x-file-upload :name="'image_id'" :path="$item?->ImageFile?->public_path" :initial="false" :id="$item?->ImageFile?->id" :type="$item?->ImageFile?->type" />
                                @error('image_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="bg-gray-100 bg-opacity-25 px-6 py-4">
                        <div class="text-right">
                            <x-link class="bg-dark-300 inline-block rounded-lg px-4 py-2 text-sm" href="{{ route('items.index') }}">Back</x-link>
                            <x-button class="px-3 py-2 text-sm">Update</x-button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
