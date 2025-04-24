<!-- Main modal -->
<div wire:ignore.self id="authentication-modal-Product" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
    data-modal-backdrop="static" data-modal-show="true">

    <div class="relative w-full max-w-md max-h-full p-4">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{$formtitle}}
                </h3>
                <button type="button"
                data-modal-hide="authentication-modal-Product"
                onclick="resetProductModal()"
                class="end-2.5 text-red-400 bg-transparent hover:bg-gray-200 hover:text-red-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                   <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
             </button>
            </div>

            <!-- Modal body -->
            <div class="p-4 md:p-5">

                <form class="space-y-4" action="#">
                    <div>
                        @if (session('status-updated'))
                        <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Info</span>
                            <div class="text-sm font-medium ms-3">
                                {{ session('status-updated') }}
                            </div>
                        </div>
                         @endif

                        <label for="product" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product</label>
                        <input wire:model="name" type="text" name="brand"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                        <label for="desc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <input wire:model="description" type="text" name="image"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                        @error('Description')
                            <span class="text-danger"> {{$message}} </span>
                        @enderror
                        <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                        <input wire:model="price" type="number" name="price"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                        @error('price')
                            <span class="text-danger"> {{$message}} </span>
                        @enderror
                    </div>
                    @if($editform)
                    <button wire:click="update" type="button" class="w-full text-white bg-blue-700 hover:bg-blue-800 transition-transform duration-100 ease-in-out active:scale-90 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
                    @else
                    <button wire:click="save" type="button" class="w-full text-white bg-blue-700 hover:bg-blue-800 transition-transform duration-100 ease-in-out active:scale-90 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
                    @endif
                </form>

            </div>
        </div>
    </div>
</div>
<script>
    function resetProductModal() {
        // Reset form fields when click on close button
        document.querySelector('input[wire\\:model="name"]').value = '';
        document.querySelector('input[wire\\:model="description"]').value = '';
        document.querySelector('input[wire\\:model="price"]').value = '';
    }



</script>
