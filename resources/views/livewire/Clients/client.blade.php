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
    page: 1,
    pageSize: 5,
    get filtered() {
        const q = this.search.toLowerCase().trim();
        if (!q) {
            return this.clients;
        }
        return this.clients.filter(c =>
            c.name.toLowerCase().includes(q) ||
            c.phone.includes(q)
        );
    },
    get totalPages() {
        return Math.ceil(this.filtered.length / this.pageSize) || 1;
    },
    paginated() {
        const start = (this.page - 1) * this.pageSize;
        return this.filtered.slice(start, start + this.pageSize);
    },
    setPage(p) {
        if (p < 1 || p > this.totalPages) return;
        this.page = p;
    },
    setPageSize(size) {
        this.pageSize = size;
        this.page = 1;
    },
    openClientModal(clientId) {
        // Direct Livewire call instead of dispatching browser event
        Livewire.dispatch("edit-mode", { id: clientId });
        
        // Show the modal
        const modal = document.getElementById("modalEl");
        if (modal) {
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        }
    }
}'
>
    <!-- Front-end search field -->
    <div class="relative max-w-md mx-auto">
        <input
            x-model="search"
            type="text"
            placeholder="Search Client or Phone N°"
            class="block w-full pl-4 pr-12 py-1.5 text-lg rounded-lg border"
        />
        <button
            type="button"
            x-show="search"
            @click="search = ''"
            class="absolute inset-y-0 right-2 flex items-center transition-colors rounded-lg hover:text-red-600"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Client table -->
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 mt-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="text-gray-900">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                        <thead class="text-xs font-semibold text-gray-900 uppercase bg-gray-100 dark:bg-gray-800 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="hidden px-6 py-3 text-center">ID</th>
                                <th scope="col" class="px-6 py-3 text-center">Client Name</th>
                                <th scope="col" class="px-6 py-3 text-center">Phone N°</th>
                                <th scope="col" class="px-6 py-3 text-center">SOLD</th>
                                <th scope="col" class="px-6 py-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="client in paginated()" :key="client.id">
                                <tr class="divide-y">
                                    <td class="hidden px-6 py-4 text-center" x-text="`#${client.id}`"></td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-sm font-medium ring-1 ring-inset ring-blue-600/10 px-2 py-1 min-w-[1.5rem] bg-blue-50 text-blue-600 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/30 whitespace-nowrap" x-text="client.name"></span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-sm font-medium ring-1 ring-inset ring-red-600/10 px-2 py-1 min-w-[1.5rem] bg-red-50 text-red-600 dark:bg-red-400/10 dark:text-red-400 dark:ring-red-400/30 whitespace-nowrap" x-text="client.phone"></span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-sm font-medium ring-1 ring-inset ring-green-600/10 px-2 py-1 min-w-[1.5rem] bg-green-50 text-green-600 dark:bg-green-400/10 dark:text-green-400 dark:ring-green-400/30 whitespace-nowrap" x-text="new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2 }).format(client.sold || 0) + ' DA'"></span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <!-- Updated View Button -->
                                        <button 
                                            @click="openClientModal(client.id)"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                        >
                                            View
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="filtered.length === 0">
                                <td colspan="5" class="p-4 text-center font-semibold text-xl text-red-700">No clients match your search</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Pagination Controls -->
<!-- Replace your existing pagination section with this improved version -->

<!-- Pagination Controls -->
<!-- Replace your existing pagination section with this improved version -->

<!-- Pagination Controls -->
<div class="flex items-center justify-between mt-4">
    <!-- Empty div for spacing -->
    <div class="w-32"></div>

    <!-- Centered Pagination -->
    <div class="flex justify-center">
        <nav aria-label="Page navigation">
            <ul class="inline-flex">
                <!-- Prev Button -->
                <li>
                    <button @click="setPage(page-1)" :disabled="page === 1"
                        class="flex items-center justify-center h-8 px-3 text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white disabled:opacity-50">
                        <svg class="w-3.5 h-3.5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4" />
                        </svg>
                    </button>
                </li>

                <!-- Page 1 (always show if not current) -->
                <li x-show="page > 3">
                    <button @click="setPage(1)"
                        class="flex items-center justify-center h-8 px-3 text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        1
                    </button>
                </li>

                <!-- Ellipsis after page 1 -->
                <li x-show="page > 4">
                    <span class="flex items-center justify-center h-8 px-3 text-gray-500 bg-white border border-gray-300">
                        ...
                    </span>
                </li>

                <!-- Previous page (if not page 1 or 2) -->
                <li x-show="page > 2">
                    <button @click="setPage(page-1)"
                        class="flex items-center justify-center h-8 px-3 text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                        x-text="page-1">
                    </button>
                </li>

                <!-- Current Page -->
                <li>
                    <button
                        class="flex items-center justify-center h-8 px-3 text-blue-600 border-blue-300 bg-blue-50 font-bold text-lg border focus:z-10"
                        x-text="page">
                    </button>
                </li>

                <!-- Next page (if not second to last or last) -->
                <li x-show="page < totalPages - 1">
                    <button @click="setPage(page+1)"
                        class="flex items-center justify-center h-8 px-3 text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                        x-text="page+1">
                    </button>
                </li>

                <!-- Ellipsis before last page -->
                <li x-show="page < totalPages - 3">
                    <span class="flex items-center justify-center h-8 px-3 text-gray-500 bg-white border border-gray-300">
                        ...
                    </span>
                </li>

                <!-- Last page (always show if not current) -->
                <li x-show="page < totalPages - 2">
                    <button @click="setPage(totalPages)"
                        class="flex items-center justify-center h-8 px-3 text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                        x-text="totalPages">
                    </button>
                </li>

                <!-- Next Button -->
                <li>
                    <button @click="setPage(page+1)" :disabled="page === totalPages"
                        class="flex items-center justify-center h-8 px-3 text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white disabled:opacity-50">
                        <svg class="w-3.5 h-3.5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </button>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Rows Per Page Selector -->
    <div class="flex items-center gap-2">
        <label class="text-sm text-gray-600">Rows per page</label>
        <select x-model.number="pageSize" @change="setPageSize($event.target.value)"
            class="px-4 py-1 text-sm border rounded">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>
</div>

<!-- Results Info with Page Jump -->
<div class="flex justify-center items-center gap-4 w-full mt-2">
    <span class="text-sm text-gray-700 dark:text-gray-400">
        Showing <span class="font-semibold text-gray-900" x-text="filtered.length === 0 ? 0 : ((page-1)*pageSize+1)"></span>
        to <span class="font-semibold text-gray-900" x-text="Math.min(page*pageSize, filtered.length)"></span>
        of <span class="font-semibold text-gray-900" x-text="filtered.length"></span> Entries
    </span>
</div>

                    <!-- If there are no clients -->
                    @if ($clients->isEmpty())
                        <p class="p-4 text-gray-500">No clients available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
<livewire:view-client />
