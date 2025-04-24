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
                         @if ($liteform)
                         <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Client Name</label>
                         <input wire:model="name" type="text" name="name"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                         
                         @error('name')
                             <span class="text-danger"> {{$message}} </span>
                         @enderror
                         <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone N°</label>
                         <input wire:model="phone" type="number" name="phone"
                         oninput="if(this.value.length > 10) this.value = this.value.slice(0, 10)"
                         class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                         @error('phone')
                             <span class="text-danger"> {{$message}} </span>
                         @enderror
                         @else
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Client Name</label>
                        <input wire:model="name" type="text" name="name"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                        @error('name')
                            <span class="text-danger"> {{$message}} </span>
                        @enderror
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone N°</label>
                        <input wire:model="phone" type="number" name="phone" oninput="if(this.value.length > 10) this.value = this.value.slice(0, 10)"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                        @error('phone')
                            <span class="text-danger"> {{$message}} </span>
                        @enderror
                        <label for="phone2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone2 N°</label>
                        <input wire:model="phone2" type="number" name="phone2"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                        @error('phone2')
                            <span class="text-danger"> {{$message}} </span>
                        @enderror
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                        <input wire:model="address" type="text" name="address"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                        @error('address')
                            <span class="text-danger"> {{$message}} </span>
                        @enderror
                        <label for="remark" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                        <input wire:model="remark" type="text" name="remark"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                        @error('remark')
                            <span class="text-danger"> {{$message}} </span>
                        @enderror
                        <label for="sold" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sold</label>
                        <input wire:model="sold" type="number" name="sold"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                        @error('sold')
                            <span class="text-danger"> {{$message}} </span>
                        @enderror
                        @endif

                    </div>
                    @if($editform)
                    <button wire:click="update" type="button" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
                    @else
                    <button wire:click="save" type="button" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
                    @endif

                </form>
            </div>
        </div>
    </div>
</div>
