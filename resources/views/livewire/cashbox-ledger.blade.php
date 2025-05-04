<div>
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="w-full text-sm text-gray-700 table-fixed">
            <thead class="text-xs uppercase bg-gray-100">
                <tr>
                    <th class="w-8 px-1 py-2 text-center">OK</th>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Start</th>
                    <th class="px-4 py-2 text-green-600">CASH IN</th>
                    <th class="px-4 py-2 text-red-600">CASH OUT</th>
                    <th class="px-4 py-2">Balance</th>
                    <th class="px-4 py-2">Decalage</th>
                    <th class="w-16 px-2 py-2 text-center">Edited</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dailyBalances as $date => $data)
                @php
                $checked = $data['manual_end_set'];
                $rowColor = $checked ? 'bg-green-50' : 'bg-white';
              @endphp

                    <tr class="border-t {{ $rowColor }}">
                        {{-- New column: checkbox indicator --}}
 {{-- OK column, tiny --}}
 <td class="w-8 px-1 py-2 text-center">
    @if($checked)
        {{-- Green check icon --}}
        <svg class="inline-block w-5 h-5 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
            <path d="M8 12l2 2 4-4" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    @else
        {{-- Red X icon --}}
        <svg class="inline-block w-5 h-5 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
            <path d="M9 9l6 6m0-6l-6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    @endif
</td>                        <td class="px-4 py-2 font-medium">{{ \Carbon\Carbon::parse($data['created_at'])->format('H:i-d/m/Y') }}</td>
                        <td class="px-4 py-2">{{ number_format($data['start'], 2, ',', ' ') }} DA</td>
                        <td class="px-4 py-2 text-green-700">{{ number_format($data['entree'], 2, ',', ' ') }} DA</td>
                        <td class="px-4 py-2 text-red-700">{{ number_format(collect($data['mouvements'])->sum('montant'), 2, ',', ' ') }} DA</td>
                        <td class="px-4 py-2 font-semibold">{{ number_format($data['solde'], 2, ',', ' ') }} DA</td>
                        <td class="px-4 py-2 font-semibold">{{ number_format($data['decalage'] ?? 0,2,',',' ') }} DA</td>
                        <td class="w-16 px-2 py-2 text-xs text-center text-gray-600">
                            @if($checked)
                              {{ \Carbon\Carbon::parse($data['updated_at'])->format('H:i-d/m/Y') }}
                            @else
                              —
                            @endif
                          </td>
                        <td class="px-4 py-2">
                            <button wire:click="view('{{ $date }}')" class="font-medium text-blue-600 hover:underline">Details</button>
                            <button wire:click="editEndValue('{{ $date }}')" class="text-yellow-600 hover:underline">End Value</button>
                        </td>


                    </tr>
                @empty
                    <tr><td colspan="8" class="px-4 py-6 text-center text-gray-500">No data available.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>



    @if($selectedDate)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-opacity-60 backdrop-blur-sm">
        <div class="w-11/12 md:w-4/5 lg:w-3/4 max-w-4xl bg-white rounded-xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden">
            <!-- Header - Always visible -->
            <div class="sticky top-0 z-10 flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="flex items-center text-xl font-semibold text-gray-800 gap-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    <span>Details of: <span class="text-blue-600">{{ \Carbon\Carbon::parse($selectedDate)->format('d/m/Y') }}</span></span>
                </h3>

                <button wire:click="$set('selectedDate', null)" class="p-2 text-gray-400 transition-all duration-200 bg-transparent rounded-full hover:text-red-500 hover:bg-gray-100">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Scrollable Content Area -->
            <div class="flex-1 px-6 py-4 overflow-y-auto">
                <!-- Start Value Card -->
                <div class="flex items-center px-4 py-3 mb-6 border border-blue-100 rounded-lg bg-blue-50">
                    <div class="mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex items-baseline space-x-2">
                        <h6 class="text-2xl font-bold">START VALUE :</h6>
                        <p class="text-2xl font-bold text-blue-800">{{ number_format($dailyBalances[$selectedDate]['start'],2,',',' ') }} DA</p>
                    </div>
                </div>

                <!-- Invoices Section -->
                <div class="mb-8">
                    <div class="flex items-center gap-2 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                        </svg>
                        <h4 class="text-lg font-semibold text-gray-800">Invoices</h4>
                    </div>

                    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="w-full text-gray-700">
                                <thead>
                                        <th class="px-4 py-3 font-medium text-center text-gray-700">ID</th>
                                        <th class="px-4 py-3 font-medium text-center text-gray-700">CLIENT</th>
                                        <th class="px-4 py-3 font-medium text-center text-gray-700">CAR</th>
                                        <th class="px-4 py-3 font-medium text-center text-gray-700">VALUE IN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($facturesOfDay as $facture)
                                        <tr class="border-t border-gray-200 hover:bg-gray-50">
                                            <td class="px-4 py-3 text-center text-gray-800">
                                                <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-base font-medium ring-1 ring-inset px-2 py-1 min-w-[1.5rem]  whitespace-nowrap cursor-pointer">
                                                #{{ $facture->id }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-base font-medium ring-1 ring-inset ring-blue-600/10 px-2 py-1 min-w-[1.5rem] bg-blue-50 text-blue-600 whitespace-nowrap">
                                                    {{ $facture->client->name }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-base font-medium ring-1 ring-inset ring-yellow-600/10 px-2 py-1 min-w-[1.5rem] bg-yellow-50 text-yellow-600 whitespace-nowrap">
                                                    {{ $facture->car->model }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-base font-medium ring-1 ring-inset ring-green-600/10 px-2 py-1 min-w-[1.5rem] bg-green-50 text-green-600 whitespace-nowrap">
                                                {{ number_format($facture->total_amount,2,',',' ') }} DA
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-6 italic text-center text-gray-500">No invoices for this date</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr class="font-medium">
                                        <td colspan="3" class="px-4 py-3 text-lg text-right border-t">TOTAL CASH IN :</td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-lg font-medium ring-1 ring-inset ring-green-600/30 px-2 py-1 min-w-[1.5rem] bg-green-50 text-green-800 whitespace-nowrap">
                                                {{ number_format($inflow, 2, ',', ' ') }} DA
                                            </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Cash Movements Section -->
                <div class="mb-8">
                    <div class="flex items-center gap-2 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z" />
                        </svg>
                        <h4 class="text-lg font-semibold text-gray-800">Cash Out</h4>
                    </div>

                    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="w-full text-gray-700">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-4 py-3 font-medium text-center gray-700 ">ID</th>
                                        <th class="px-4 py-3 font-medium text-center text-gray-700">DESCRIPTION</th>
                                        <th class="px-4 py-3 font-medium text-center text-gray-700">VALUE OUT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($mouvementsOfDay as $mvt)
                                        <tr class="border-t border-gray-200 hover:bg-gray-50">
                                            <td class="px-4 py-3 text-center text-gray-800">
                                                <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-base font-medium ring-1 ring-inset px-2 py-1 min-w-[1.5rem]  whitespace-nowrap cursor-pointer">
                                                    #{{ $mvt->id }}</td>
                                                </span>
                                            <td class="px-4 py-3 text-center text-gray-800">
                                                <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-base font-medium ring-1 ring-inset ring-yellow-600/10 px-2 py-1 min-w-[1.5rem] bg-yellow-50 text-yellow-600 whitespace-nowrap">
                                                    {{ $mvt->description }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-center text-gray-800">
                                                <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-base font-medium ring-1 ring-inset ring-red-600/10 px-2 py-1 min-w-[1.5rem] bg-red-50 text-red-600 whitespace-nowrap">
                                                    {{ number_format($mvt->montant,2,',',' ') }} DA
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-6 italic text-center text-gray-500">No cash movements for this date</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr class="font-medium">
                                        <td colspan="2" class="px-4 py-3 text-lg text-right border-t">TOTAL CASH OUT:</td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-lg font-medium ring-1 ring-inset ring-red-600/30 px-2 py-1 min-w-[1.5rem] bg-red-50 text-red-800 whitespace-nowrap">
                                                {{ number_format(collect($mouvementsOfDay)->sum('montant'), 2, ',', ' ') }} DA
                                            </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Summary Card -->
                <div class="mb-6 overflow-hidden border border-gray-200 rounded-lg shadow-sm bg-gray-50">
                    <div class="px-4 py-3 bg-gray-100 border-b border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-800">Daily Summary</h4>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="flex items-center justify-between px-4 py-3">
                            <span class="font-semibold text-gray-700">START VALUE</span>
                            <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-base font-bold ring-1 ring-inset ring-blue-600/10 px-2 py-1 min-w-[1.5rem] bg-blue-50 text-blue-800 whitespace-nowrap">
                            {{ number_format($dailyBalances[$selectedDate]['start'],2,',',' ') }} DA
                            </span>
                        </div>
                        <div class="flex items-center justify-between px-4 py-3">
                            <span class="font-semibold text-gray-700">Total Cash In</span>
                            <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-base font-bold ring-1 ring-inset ring-green-600/10 px-2 py-1 min-w-[1.5rem] bg-green-50 text-green-600 whitespace-nowrap">
                            + {{ number_format($inflow, 2, ',', ' ') }} DA                                </span>
                        </div>
                        <div class="flex items-center justify-between px-4 py-3">
                            <span class="font-semibold text-gray-700">Total Cash Out</span>
                            <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-base font-bold ring-1 ring-inset ring-red-600/10 px-2 py-1 min-w-[1.5rem] bg-red-50 text-red-800 whitespace-nowrap">
                            - {{ number_format(collect($mouvementsOfDay)->sum('montant'), 2, ',', ' ') }} DA</span>
                        </div>
                        <div class="flex items-center justify-between px-4 py-3 bg-gray-50">
                            <span class="font-medium text-gray-800">Expected Final Balance</span>
                            <span class="text-lg inline-flex items-center justify-center gap-x-1 rounded-md  font-bold ring-1 ring-inset ring-green-600/10 px-2 py-1 min-w-[1.5rem] bg-green-50 text-green-800 whitespace-nowrap">
                                {{ number_format($total, 2, ',', ' ') }} DA</span>
                        </div>
                    </div>
                </div>

<!-- CASH COUNT & BALANCING (pure Alpine.js) -->
<div
    x-data="{
        total:  {{ $total }},                         // still read‐only
        actual: @entangle('actualCashCount').defer,   // ← NO default here!
        get decalage() { return this.actual - this.total },
        percent()     { return Math.min(Math.abs(this.decalage / this.total * 100), 100) }
    }"
    class="mb-4 overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm"
>
    <div class="px-4 py-3 bg-gray-100 border-b border-gray-200">
        <h4 class="font-medium text-gray-800">CASH COUNT & BALANCING</h4>
    </div>
    <div class="p-4">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            <!-- Expected Balance (Read-only) -->
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Expected Balance</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pr-3 pointer-events-none">
                        <span class="px-2 text-xl font-semibold text-blue-800 bg-blue-100 rounded-md">DA</span>
                    </div>
                    <input
                        type="text"
                        readonly
                        :value="total.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })"
                        class="block w-full py-2 pl-10 pr-12 text-lg font-medium border-gray-300 rounded-md cursor-not-allowed bg-gray-50"
                    >
                </div>
                <p class="mt-1 text-xs text-gray-500">Calculated from start value, cash in, and cash out</p>
            </div>

            <!-- Actual Cash Count (Editable) -->
            <div>
                <label for="actual-cash-count" class="block mb-1 text-sm font-medium text-gray-700">
                    Actual Cash Count
                </label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <!-- SVG icon -->
                    </div>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pr-3 pointer-events-none">
                        <span class="px-2 text-xl font-semibold text-blue-800 bg-blue-100 rounded-md">DA</span>
                    </div>
                    <input
                    id="actual-cash-count"
                    type="number"
                    step="0.01"
                    x-model.number="actual"
                    x-init="actual = {{ $actualCashCount ?? 0 }}"
                    @input.debounce.300ms="$wire.updateDecalage(actual)"
                    class="block w-full py-2 pl-10 pr-12 mb-2 text-lg font-medium border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500"
                  />



                </div>
                <p class="mt-1 text-xs text-gray-500">Enter the exact amount you count in the cash box</p>
            </div>

            <!-- Calculated Discrepancy (Décalage) -->
            <div class="p-4 mt-2 border border-gray-200 rounded-lg md:col-span-2 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h5 class="text-lg font-semibold text-gray-800">Discrepancy (Décalage)</h5>
                        <p class="text-sm text-gray-500">Difference between expected and actual cash</p>
                    </div>
                    <div>
                        <span
                            class="inline-flex items-center justify-center px-3 py-2 text-xl font-bold rounded-md"
                            :class="decalage < 0
                                ? 'bg-red-100 text-red-800'
                                : 'bg-green-100 text-green-800'"
                            x-text="(decalage >= 0 ? '+' : '')
                                     + decalage.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                                     + ' DA'"
                        ></span>
                    </div>
                </div>

                <!-- Visual indicator for the direction of the difference -->
                <div class="flex items-center mt-3">
                    <div class="w-full h-2 bg-gray-200 rounded-full">
                        <div
                            class="h-2 rounded-full"
                            :class="decalage < 0 ? 'bg-red-500' : 'bg-green-500'"
                            :style="{ width: percent() + '%' }"
                        ></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer button still using Livewire save -->
    <div class="flex justify-end px-6 py-4 border-t border-gray-200 bg-gray-50">
        <button
            @click.prevent="$wire.saveEndValue()"
            class="flex items-center justify-center gap-2 px-6 py-3 font-medium text-white transition bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 active:scale-95"
        >
            <!-- SVG check icon -->
            Save Changes
        </button>
    </div>
</div>


    @endif

    @if($showEndModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
                <h3 class="mb-4 text-lg font-bold">Edit End Value – {{ \Carbon\Carbon::parse($endEditDate)->format('d/m/Y') }}</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block mb-1 font-semibold">End ssValue (DA)</label>
                        <input type="number" inputmode="numeric" pattern="[0-9]*" step="0.01" wire:model.defer="endValue" class="w-full px-4 py-2 border rounded-md" />
                    </div>
                    <div class="flex justify-end">
                        <button wire:click="saveEndValue" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Save</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
