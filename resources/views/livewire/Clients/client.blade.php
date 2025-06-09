<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Clients') }}
    </h2>
</x-slot>
<div class="py-12">

    <!-- Session Status Alert -->
    @if (session('status-created'))
    <div id="alert-1" class="flex items-center p-4 mb-4 text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div class="text-sm font-medium ms-3">
            {{ session('status-created') }}
        </div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-1" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
@endif
@if (session('status-delete'))
<div id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
      <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
    </svg>
    <span class="sr-only">Info</span>
    <div class="text-sm font-medium ms-3">
        {{ session('status-delete') }}
    </div>
    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-2" aria-label="Close">
      <span class="sr-only">Close</span>
      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
      </svg>
    </button>
  </div>
@endif
    <!-- Session Status Alert -->

    <div>
        <div >

            <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                Create Client
            </button>
        </div>
        <div wire:ignore>
            <livewire:create-edit-client />
        </div>
    </div>
<!-- Search Form -->
<div
    x-data='{
        search: "",
        clients: @json($clients),
        get filtered() {
            const q = this.search.toLowerCase().trim();
            if (!q) {
                return this.clients;
            }
            return this.clients.filter(c =>
                c.name.toLowerCase().includes(q) ||
                c.phone.includes(q)
            );
        }
    }'
    class="space-y-4"
>
    <!-- Front-end search field -->
    <div class="relative max-w-md mx-auto">
        <input
            x-model="search"
            type="search"
            placeholder="Search Client or Phone N°"
            class="block w-full pl-4 pr-12 py-2.5 text-sm rounded-lg border"
        />
    </div>


    <!-- Client table -->
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="text-gray-900 ">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                        <thead class="text-xs font-semibold text-gray-900 uppercase bg-gray-100 dark:bg-gray-800 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">ID</th>
                                <th scope="col" class="px-6 py-3 text-center">Client Name</th>
                                <th scope="col" class="px-6 py-3 text-center">Phone N°</th>
                                <th scope="col" class="px-6 py-3 text-center">SOLD</th>
                                <th scope="col" class="px-6 py-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                <template x-for="client in filtered" :key="client.id">
                    <tr class="divide-y">
                        <td class="px-6 py-4 text-center" x-text="`#${client.id}`"></td>
                        <td class="px-6 py-4 text-center">

                            <span class="
                                    inline-flex items-center justify-center
                                    gap-x-1
                                    rounded-md
                                    text-sm font-medium
                                    ring-1 ring-inset ring-blue-600/10
                                    px-2 py-1
                                    min-w-[1.5rem]
                                  bg-blue-50 text-blue-600
                                  dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/30
                                    whitespace-nowrap" x-text="client.name"></span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center
                                    gap-x-1
                                    rounded-md
                                    text-sm font-medium
                                    ring-1 ring-inset ring-red-600/10
                                    px-2 py-1
                                    min-w-[1.5rem]
                                  bg-red-50 text-red-600
                                  dark:bg-red-400/10 dark:text-red-400 dark:ring-red-400/30
                                    whitespace-nowrap" x-text="client.phone"></span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span
                                class="inline-flex items-center justify-center
                                    gap-x-1
                                    rounded-md
                                    text-sm font-medium
                                    ring-1 ring-inset ring-green-600/10
                                    px-2 py-1
                                    min-w-[1.5rem]
                                  bg-green-50 text-green-600
                                  dark:bg-green-400/10 dark:text-green-400 dark:ring-green-400/30
                                    whitespace-nowrap"
                                x-text="new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2 }).format(client.sold || 0) + ' DA'"
                            ></span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <!-- Dispatch native browser events so Livewire can listen -->
                                    <!-- Modal toggle -->
                                    <button @click="$dispatch('edit-mode', { id: client.id })"
                                    data-modal-toggle="modalEl"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    View
                                    </button>

                                                                        <!-- Delete Button in Parent Blade File -->
                               {{-- <button data-modal-target="popup-modal-{{ $client->id }}" data-modal-toggle="popup-modal-{{ $client->id }}" class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                    Delete
                                    </button>
                                    <livewire:deleteclient :clientId="$client->id" /> --}}
                        </td>
                    </tr>
                </template>
                <tr x-show="filtered.length === 0">
                    <td colspan="5" class="p-4 text-center text-gray-500">No clients match your search.</td>
                </tr>
            </tbody>
                    </table>
                    <!-- If there are no clients -->
                     @if ($clients->isEmpty())
                        <p class="p-4 text-gray-500">No clients available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
                            <livewire:view-client wire:ignore.self/>
