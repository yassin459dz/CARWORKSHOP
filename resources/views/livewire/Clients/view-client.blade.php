<!-- Client View Modal -->
<div wire:ignore.self id="modalEl" data-modal-target="modalEl" aria-hidden="true" data-modal-backdrop="static"
     tabindex="-1" class="fixed inset-0 z-50 items-center justify-center hidden w-full h-screen max-h-screen p-2 bg-black/30">
    @if($deleteMode)
    <div
    x-data
    x-show="true"
    @keydown.escape.window="$wire.set('deleteMode', false)"
    @click.outside="$wire.set('deleteMode', false)"
    class="fixed inset-0 z-50 flex items-center justify-center  backdrop-blur-sm"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modalTitle"
>
    <div class="relative w-full bg-white border border-gray-300 rounded-lg shadow-xl max-w-md max-h-full p-6">
    <button wire:click="$set('deleteMode', false)" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal-{{ $clientId }}">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
    <div class="p-4 text-center md:p-5">
        
                <svg xmlns="http://www.w3.org/2000/svg" class="p-1 mx-auto text-red-700 w-14 h-14 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path  stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                <p class="mt-2 text-xl font-bold text-center text-gray-700">Deleting Client</p>
                <p class="mt-2 text-lg text-center text-gray-500 dark:text-gray-400">Are you sure you want to delete <span class="font-medium text-red-600 truncate">{{ $name }}</span> ?</p>

                <div class="flex flex-col justify-center mt-4 space-y-3 sm:flex-row sm:space-x-3 sm:space-y-0">
                <!-- Confirm Delete Button -->
                <button wire:click="deleteClient({{ $clientId }})" data-modal-hide="popup-modal-{{ $clientId }}" type="button" class=" whitespace-nowrap text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Yes, I'm sure
                </button>

                <!-- Cancel Button -->
                <button wire:click="$set('deleteMode', false)" type="button" class="whitespace-nowrap py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    No, cancel
                </button>
                </div>
            </div>
    </div>
</div>

        </div>
    @endif
     <div class="w-full max-w-3xl bg-white shadow-lg rounded-2xl dark:bg-slate-800">
        <!-- Header -->
         
        <div class="flex items-center justify-between px-6 py-3 bg-gradient-to-r rounded-t-2xl from-slate-800 to-slate-700">
            <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-white/10 ring-2 ring-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-5">
                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>

<h1 class="text-lg font-semibold text-white">{{ $name }}</h1>

                    <p class="text-xs text-slate-300">Full client profile and information</p>
                </div>
            </div>
            <button data-modal-toggle="modalEl" wire:click="cancelEdit" type="button" class="p-1 transition-colors rounded-lg text-white/80 hover:text-red-600 bg-white/10 hover:bg-white/30">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <!-- Content -->
         
        <div class="p-3 sm:p-6 lg:p-8">
            <div class="mb-3 bg-white border rounded-lg shadow-sm border-slate-200">
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                    <!-- Client Sold -->
                    <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50">
                        <h3 class="text-lg font-medium text-slate-700">Client Sold</h3>
                        @if($editMode)
                        <input type="number" wire:model.defer="sold" class="w-full px-2 py-1 text-black border rounded border-slate-200" placeholder="Sold" />
                        @else
                        <span class="px-2 py-1 text-lg font-semibold rounded-full p-2 rounded-lg
                            @if($sold < 0)
                                text-red-800 bg-red-100
                            @elseif($sold > 0)
                                text-green-800 bg-green-100
                            @else
                                text-slate-800 bg-gray-200
                            @endif">
                            @if($sold < 0) Negative
                            @elseif($sold > 0) Credit
                            @else No Sold
                            @endif
                            {{ number_format(abs($sold), 2) }} DA
                        </span>
                        @endif
                    </div>
                    <!-- Facture Count -->
                    <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50">
                        <h3 class="text-lg font-medium text-slate-700">Facture Count</h3>
                        <span class="p-2 px-2 py-1 text-lg font-semibold text-blue-800 bg-blue-100 rounded-lg">
                            {{ $factureCount }}
                        </span>
                    </div>
                </div>
            </div>
            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 gap-3 mb-3 lg:grid-cols-2">
                <!-- Contact Information Card -->
                <div class="p-2 px-3 bg-white border rounded-lg shadow-sm border-slate-200">
                    <h4 class="flex items-center mb-3 text-base font-semibold text-slate-800">
                        <svg class="w-4 h-4 mr-2 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Contact Information
                    </h4>
                    <div class="space-y-2">
                        <div class="p-2 rounded-lg bg-blue-50">
                            <div class="text-sm font-medium text-center text-blue-600">Name</div>
                            @if($editMode)
                                <input type="text" wire:model.defer="name" class="w-full px-2 py-1 text-black border rounded border-slate-200" placeholder="Full Name" autofocus />
                                @error('name') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                            @else
                                <div class="text-base font-semibold text-center text-blue-800">{{ $name ?? 'Not provided' }}</div>
                            @endif
                        </div>
                        <div class="p-2 rounded-lg bg-blue-50">
    <div class="text-sm font-medium text-center text-blue-600">Phone Numbers</div>

    @if($editMode)
        <div class="flex gap-x-2">
            <div class="w-1/2">
                <input type="text" wire:model.defer="phone"
                    class="w-full px-2 py-1 mb-1 text-black border rounded border-slate-200"
                    placeholder="Phone 1" />
                @error('phone')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="w-1/2">
                <input type="text" wire:model.defer="phone2"
                    class="w-full px-2 py-1 mb-1 text-black border rounded border-slate-200"
                    placeholder="Phone 2 (optional)" />
            </div>
        </div>
    @else
        <div class="text-base font-semibold text-center text-blue-800">{{ $phone ?? 'Not provided' }}</div>
        @if($phone2)
            <div class="text-base font-semibold text-center text-blue-800">{{ $phone2 }}</div>
        @endif
    @endif
</div>

                        <div class="p-2 rounded-lg bg-green-50">
                            <div class="text-sm font-medium text-center text-green-600">Address</div>
                            @if($editMode)
                                <input type="text" wire:model.defer="address" class="w-full px-2 py-1 text-black border rounded border-slate-200" placeholder="Address" />
                                @error('address') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                            @else
                                <div class="text-base font-semibold text-center text-green-800">{{ $address ?? 'Not provided' }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Client Duration Card -->
                @if(isset($client) && isset($client->created_at))
                <div class="p-2 px-3 bg-white border rounded-lg shadow-sm border-slate-200">
                    <h4 class="flex items-center mb-3 text-base font-semibold text-slate-800">
                        <svg class="w-4 h-4 mr-2 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Client History
                    </h4>
                    <div class="space-y-2" x-data="clientDuration('{{ $client->created_at->toISOString() }}')" x-init="init()">
                        <div class="p-2 rounded-lg bg-blue-50">
                            <div class="text-sm font-medium text-center text-blue-600">Member Since</div>
                            <div class="text-base font-semibold text-center text-blue-800">{{ $date }}</div>
                        </div>
                        <div class="p-2 rounded-lg bg-green-50">
                            <div class="text-sm font-medium text-center text-green-600">Duration</div>
                            <div class="text-base font-semibold text-center text-green-800" x-text="duration"></div>
                        </div>
                        <div class="p-2 rounded-lg bg-red-50">
                            <div class="text-sm font-medium text-center text-red-600">Last Updated</div>
                            <div class="text-base font-semibold text-center text-red-800">{{ $updated }}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <!-- Remarks Section - Full Width at Bottom -->
            <div class="px-3 py-2 bg-white border rounded-lg shadow-sm border-slate-200">
                <h4 class="flex items-center mb-2 text-base font-semibold text-slate-800">
                    <svg class="w-4 h-4 mr-2 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                    Remarks & Notes
                </h4>
                <div >
                    @if($editMode)
                    <textarea wire:model.defer="remark"
    class="w-full px-2 py-1 text-sm text-black border rounded border-slate-200 "
    placeholder="Add remarks or notes..."></textarea>
@error('remark')
    <span class="text-xs text-red-600">{{ $message }}</span>
@enderror

                    @else
                        <p class="p-2 text-base font-semibold text-center text-yellow-800 rounded-lg bg-yellow-50">
                            {{ $remark ?? 'No remarks or notes have been added for this client.' }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
        <!-- Footer Actions -->
        <div class="flex items-center justify-end px-6 pb-3 rounded-b-2xl bg-slate-50 border-slate-200">
            <div class="flex space-x-2">
                @if($editMode)
                    <button type="button" wire:click="saveEdit" wire:loading.attr="disabled" class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-semibold text-white transition bg-green-600 rounded-lg shadow hover:bg-green-700">
                        <span wire:loading.remove>Save</span>
                    </button>
                    <button type="button" wire:click="cancelEdit" wire:loading.attr="disabled" class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-semibold text-white transition bg-red-600 rounded-lg shadow hover:bg-red-700">
                        <span wire:loading.remove>Cancel</span>
                    </button>
                @else
                    <button type="button" wire:click="enableEditMode" class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-semibold text-white transition bg-green-600 rounded-lg shadow hover:bg-green-700">
                        Edit
                    </button>
                    <button type="button" wire:click="enableDeleteMode" class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-semibold text-white transition bg-red-600 rounded-lg shadow hover:bg-red-700">
                        Delete
                    </button>
                @endif
            </div>
        </div>
    </div>
    <script>
        function clientDuration(clientSinceDate) {
            return {
                duration: 'Calculating...',
                init() {
                    const start = new Date(clientSinceDate);
                    const now = new Date();
                    let years = now.getFullYear() - start.getFullYear();
                    let months = now.getMonth() - start.getMonth();
                    let days = now.getDate() - start.getDate();
                    if (days < 0) {
                        months--;
                        const prevMonth = new Date(now.getFullYear(), now.getMonth(), 0);
                        days += prevMonth.getDate();
                    }
                    if (months < 0) {
                        years--;
                        months += 12;
                    }
                    let parts = [];
                    if (years > 0) parts.push(`${years} year${years > 1 ? 's' : ''}`);
                    if (months > 0) parts.push(`${months} month${months > 1 ? 's' : ''}`);
                    if (days > 0) parts.push(`${days} day${days > 1 ? 's' : ''}`);
                    if (parts.length === 0) parts.push('0 days');
                    this.duration = parts.join(', ');
                }
            }
        }
    </script>
</div>
