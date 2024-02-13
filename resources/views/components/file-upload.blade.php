@props([
'initial' => true,
'name' => '',
'path' => '',
'id' => null,
'type' => null,
])

<div class="text-center">
    <div class="mb-2 grid gap-1 lg:grid-cols-1">
        @if ($path !== '')
        <div class="display-{{ $id }} mx-auto mb-2 h-[156px] w-[156px] overflow-hidden border-[1px] border-gray-300">
            <x-image-modal :id="$id" :image="$path" :alt="''" :type="$type" />
        </div>
        @else
        @if ($initial)
        <div class="display-{{ $id }} mx-auto mb-2 h-[156px] w-[156px] overflow-hidden border-[1px] border-gray-300">
            <img class="h-full w-full overflow-hidden rounded-full" src="{{ asset('images/no_img.jpg') }}" alt="No Image Found">
        </div>
        @else
        <div class="display-{{ $id }} mx-auto mb-2 h-[156px] w-[156px] overflow-hidden border-[1px] border-gray-300">
        </div>
        @endif
        @endif

        <input class="hidden w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 px-3 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400" id="upload-{{ $id }}" name="{{ $name }}" type="file" aria-describedby="user_avatar_help">
    </div>
    <label class='inline-flex cursor-pointer items-center rounded-md border border-transparent bg-gray-800 px-3 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900' for="upload-{{ $id }}">
        @if ($type === 'video/mp4')
        Choose Your Video
        @else
        Choose Your Photo
        @endif
    </label>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help_{{ $id }}">PNG,
        JPEG,
        JPG or PDF</p>
</div>

<script>
    document.querySelector('#upload-{{ $id }}').addEventListener('change', () => {
        let reader = new FileReader();
        reader.readAsDataURL(document.querySelector('#upload-{{ $id }}').files[0]);
        reader.addEventListener('load', () => {
            document.querySelector('.display-{{ $id }}').innerHTML = `<img src=${reader.result} alt='pkt'
        style="width:100%; height:100%; background-size:cover;object-fit:cover;" />`;
        });
    });
</script>
