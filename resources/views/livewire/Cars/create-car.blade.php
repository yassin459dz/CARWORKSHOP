<!-- Main modal -->
<div wire:ignore.self id="authentication-modal" tabindex="-1" aria-hidden="true"
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
                <button wire:click="refreshPage" id="close-modal" type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
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

                    </div>


                    @if ($brandform)
                    <button wire:click="closebrand"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                      </svg>
                            </button>
                    <label for="brand" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Brand Name</label>
                    <input wire:model="brand" type="text" name="brand"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                    @error('brand')
                        <span class="text-danger"> {{$message}} </span>
                    @enderror
                    <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Image</label>
                    <input wire:model="image" type="text" name="image"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                    @error('image')
                        <span class="text-danger"> {{$message}} </span>
                    @enderror
                    <button wire:click="submit" type="button" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>

                    {{-- this is show the normal form --}}

                    @else
                    <button wire:click="addbrand"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                       +
                   </button>
                             <!-- THE SEARCHABLE DROPDOWN MENU -->
                    <div class="max-w-sm">
                        <div class="relative max-w-sm">
                            <!-- Brand Dropdown -->
                            <div class="relative" x-data="{ open: false, search: '' }" @click.away="open = false">
                                <!-- Input field to filter brands -->
                                <div >
                                    <label for="brand" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Brand</label>
                                    <input
                                        type="text"
                                        class="block w-full p-2 text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                        x-model="search"
                                        @focus="open = true"
                                        @input="open = true"
                                    />
                                </div>

                                <!-- Filtered Brand Options Dropdown -->
                                <div class="absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded-lg dark:bg-neutral-800 dark:border-neutral-700"
                                     x-show="open && search.length > 0"
                                     @click.away="open = false">
                                    <div class="max-h-72 rounded-b-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                                        <template x-for="brand in {{ json_encode($allbrands) }}" :key="brand.id">
                                            <div
                                                class="flex items-center w-full px-4 py-2 text-sm text-gray-800 cursor-pointer hover:bg-gray-100 dark:hover:bg-neutral-700 dark:text-neutral-200"
                                                @click="$wire.set('brand_id', brand.id); open = false; search = brand.brand"
                                                x-show="brand.brand.toLowerCase().includes(search.toLowerCase())">
                                                <span x-text="brand.brand"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <!-- End Brand Dropdown -->
                        </div>
                   <label for="model" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Car Model</label>
                   <input wire:model="model" type="text" name="model"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                   @error('model')
                       <span class="text-danger"> {{$message}} </span>
                   @enderror

                   @if($editform)
                   <button wire:click="update" type="button" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
                   @else
                   <button wire:click="save" type="button" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
                   @endif

                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
