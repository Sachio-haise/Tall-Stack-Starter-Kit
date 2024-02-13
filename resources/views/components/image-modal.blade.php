@props(['id', 'image', 'alt', 'type'])

<div>
    <div class="mb-1 flex">
        <figure class="relative flex w-full cursor-pointer items-center justify-center transition-all duration-300" data-modal-target="default-modal{{ $id }}" data-modal-toggle="default-modal{{ $id }}">
            <a href="#">
                @if ($type == 'application/pdf')
                <img class="rounded-lg" src="{{ url('images/pdf-page.png') }}" alt="{{ $alt }}" width="100">
                @elseif($type === 'video/mp4')
                <div class="h-32 w-32 overflow-hidden">

                    <video>
                        <source src="{{ $image }}" type="video/mp4" disabled>
                        Your browser does not support the video tag.
                    </video>
                </div>
                @else
                <img class="rounded-lg" src="{{ $image }}" alt="{{ $alt }}">
                @endif
            </a>
        </figure>
    </div>

    <!-- Main modal -->
    <div class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0" id="default-modal{{ $id }}" aria-hidden="true" tabindex="-1">
        <div class="relative max-h-full w-full max-w-2xl p-4">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Previous Data
                    </h3>
                    <button class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal{{ $id }}" type="button">
                        <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="flex justify-center space-y-4 p-4 md:p-5">
                    @if ($type == 'application/pdf')
                    <object type="application/pdf" data="{{ $image }}" width="100%" height="500px">
                        <p>It appears your browser does not support embedded PDFs. You can <a href="{{ $image }}" target="_blank">download the PDF</a> instead.</p>
                    </object>
                    @elseif($type === 'video/mp4')
                    <video controls width="250">
                        <source src="{{ $image }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    @else
                    <img class="rounded-lg" src="{{ $image }}" alt="{{ $alt }}">
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
