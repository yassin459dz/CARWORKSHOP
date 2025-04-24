<!-- Modal HTML in Livewire Component -->
<div id="popup-modal-{{ $product_id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full p-4">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal-{{ $product_id }}">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 text-center md:p-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="p-1 mx-auto text-red-700 w-14 h-14 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path  stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                <p class="mt-2 text-xl font-bold text-center text-gray-700">Deleting Product</p>
                <p class="mt-2 text-lg text-center text-gray-700 dark:text-gray-400">Are you sure you want to delete <span class="font-medium text-red-600 truncate">{{ $ProductName}} </span><span class="font-medium text-green-600 truncate"> {{ $ProductDesq}}</span> ?</p>

                <div class="flex flex-col justify-center mt-4 space-y-3 sm:flex-row sm:space-x-3 sm:space-y-0">
                <!-- Confirm Delete Button -->
                <button wire:click="deleteProduct" data-modal-hide="popup-modal-{{ $product_id }}" type="button" class=" whitespace-nowrap text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Yes, I'm sure
                </button>

                <!-- Cancel Button -->
                <button data-modal-hide="popup-modal-{{ $product_id }}" type="button" class=" whitespace-nowrap py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    No, Cancel
                </button>
                </div>
            </div>
        </div>
    </div>
</div>
