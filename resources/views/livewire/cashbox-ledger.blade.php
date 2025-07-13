<div>
    <div>
        @if(! $unlocked)
        <form
          autocomplete="off"
          wire:submit.prevent="unlock"
          class="max-w-sm p-6 mx-auto mt-20 bg-white rounded-lg shadow"
        >
          <h2 class="mb-4 text-xl font-semibold">Enter Cashbox Password</h2>

          <!-- Dummy hidden fields to trip Chrome up -->
          <input type="text" name="fakeusernameremembered" style="display:none">
          <input type="password" name="fakepasswordremembered" style="display:none" >

          <!-- Real password field -->
          <input
            id="cashbox-password"
            name="cashbox-pass"
            type="password"
            wire:model.defer="enteredPassword"
            onfocus="this.removeAttribute('readonly');"
            autocomplete="one-time-code"
            class="w-full px-3 py-2 mb-2 border rounded"
            placeholder="Password"
                          autocomplete="false"
          />


          @error('enteredPassword')
            <p class="text-sm text-red-600">{{ $message }}</p>
          @enderror

          <button
            type="submit"
            class="w-full px-4 py-2 mt-4 text-white bg-blue-600 rounded hover:bg-blue-700"
          >
            Unlock
          </button>
        </form>
      @else
          {{-- *** All of your existing cashbox-ledger UI goes here *** --}}
          <button
          wire:click="refreshSession"
          class="absolute top-0 right-0 px-6 py-2 mt-2 mr-4 font-medium text-white transition-transform duration-100 ease-in-out bg-blue-600 rounded-lg shadow-md text-gl hover:bg-blue-700 active:scale-90">
          Lock Cashbox
        </button>
<!-- Replace the existing table structure in your blade template -->
<div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
    <!-- Table Header with Gradient -->
    <div class="bg-gradient-to-r from-slate-800 to-slate-700 px-6 py-4">
        <h2 class="text-white text-lg font-semibold flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Daily Balance Overview
        </h2>
    </div>

<!-- Responsive Table Wrapper -->
<div class="overflow-x-auto">
        <table class="w-full text-sm text-gray-700 min-w-full">
<thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
    <tr>
        <th class="px-1 py-4 w-12 text-center font-semibold text-gray-800">Status</th>
        <th class="px-1 py-4 text-center font-semibold text-gray-800">Date & Time</th>
        <th class="px-1 py-4 text-center font-semibold text-gray-800">Starting Balance</th>
        <th class="px-1 py-4 text-center font-bold text-blue-700">
            <div class="flex justify-center items-center">
                SALES
            </div>
        </th>
        <th class="px-1 py-4 text-center font-bold text-green-700">
            <div class="flex justify-center items-center">
                CASH IN
            </div>
        </th>
        <th class="px-1 py-4 text-center font-bold text-red-700">
            <div class="flex justify-center items-center">
                CASH OUT
            </div>
        </th>
        <th class="px-1 py-4 text-center font-semibold text-gray-800">
            <div class="flex justify-center items-center">
                Decalage
            </div>
        </th>
        <th class="w-20 px-1 py-4 text-center font-semibold text-gray-800">Last Edit</th>
        <th class="px-1 py-4 text-center font-semibold text-gray-800">Actions</th>
    </tr>
</thead>

<tbody class="divide-y divide-gray-100">
    @forelse($dailyBalances as $date => $data)
    @php
        $checked = $data['manual_end_set'];
        $rowColor = $checked ? 'bg-gradient-to-r from-green-50 to-emerald-50' : 'bg-white hover:bg-gray-50';
    @endphp

    <tr class="border-t {{ $rowColor }} transition-all duration-300 hover:shadow-md text-center">
        {{-- Status --}}
        <td class="w-12 px-1 py-2">
            @if($checked)
                <div class="inline-flex items-center justify-center w-8 h-8 bg-green-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>
            @else
                <div class="inline-flex items-center justify-center w-8 h-8 bg-red-100 rounded-full">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            @endif
        </td>

        {{-- Date & Time --}}
        <td class="px-1 py-2">
            <div class="flex flex-col items-center">
                <span class="rounded-md text-sm font-bold ring-1 ring-inset ring-gray-600/10 px-2 py-1 bg-gray-50 text-gray-800">
                    {{ \Carbon\Carbon::parse($data['created_at'])->format('d/m/Y') }}
                </span>
                <span class="rounded-md text-xs font-bold ring-1 ring-inset ring-gray-600/10 px-2 py-1 bg-gray-50 text-gray-800">
                    {{ \Carbon\Carbon::parse($data['created_at'])->format('H:i') }}
                </span>
            </div>
        </td>

        {{-- Starting Balance --}}
        <td class="px-1 py-2">
            <span class="inline-flex justify-center items-center rounded-md text-base font-bold ring-1 ring-inset ring-gray-600/10 px-2 py-1 bg-blue-50 text-gray-800">
                {{ number_format($data['start'], 2, ',', ' ') }} DA
            </span>
        </td>

        {{-- SALES --}}
        <td class="px-1 py-2">
            <span class="inline-flex justify-center items-center rounded-md text-base font-bold ring-1 ring-blue-600/10 px-2 py-1 bg-blue-50 text-blue-800">
                {{ number_format($data['entree'], 2, ',', ' ') }} DA
            </span>
        </td>

        {{-- CASH IN --}}
        <td class="px-1 py-2">
            <span class="inline-flex justify-center items-center rounded-md text-base font-bold ring-1 ring-green-600/10 px-2 py-1 bg-green-50 text-green-800">
                {{ number_format($data['cash_in'], 2, ',', ' ') }} DA
            </span>
        </td>

        {{-- CASH OUT --}}
        <td class="px-1 py-2">
            <span class="inline-flex justify-center items-center rounded-md text-base font-bold ring-1 ring-red-600/10 px-2 py-1 bg-red-50 text-red-800">
                {{ number_format($data['sortie'], 2, ',', ' ') }} DA
            </span>
        </td>

        {{-- Decalage --}}
        <td class="px-1 py-2">
            @php
                $decalage = $data['decalage'] ?? 0;
                $decalageColor = $decalage > 0
                    ? 'text-green-800 bg-green-100 ring-green-600/10'
                    : ($decalage < 0
                        ? 'text-red-800 bg-red-100 ring-red-600/10'
                        : 'text-gray-800 bg-gray-100 ring-gray-600/10');
            @endphp
            <span class="inline-flex justify-center items-center rounded-md text-base font-bold ring-1 ring-inset px-2 py-1 whitespace-nowrap {{ $decalageColor }}">
                {{ $decalage > 0 ? '+' : '' }}{{ number_format($decalage, 2, ',', ' ') }} DA
            </span>
        </td>

        {{-- Last Edit --}}
        <td class="px-1 py-2">
            <div class="flex flex-col items-center">
                @if($checked)
                    <span class="rounded-md text-sm font-bold ring-1 ring-inset ring-gray-600/10 px-2 py-1 bg-gray-50 text-gray-800">
                        {{ \Carbon\Carbon::parse($data['updated_at'])->format('d/m/Y') }}
                    </span>
                    <span class="rounded-md text-xs font-bold ring-1 ring-inset ring-gray-600/10 px-2 py-1 bg-gray-50 text-gray-800">
                        {{ \Carbon\Carbon::parse($data['updated_at'])->format('H:i') }}
                    </span>
                @else
                    <span class="text-gray-400">—</span>
                @endif
            </div>
        </td>

        {{-- Actions --}}
        <td class="px-1 py-2">
            <div class="flex justify-center space-x-2">
                <button wire:click="view('{{ $date }}')" 
                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:ring-blue-500 transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Details
                </button>
            </div>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="9" class="px-1 py-12 text-center">
            <div class="flex flex-col items-center">
                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-500 text-lg font-medium">No data available</p>
                <p class="text-gray-400 text-sm">Daily balance records will appear here</p>
            </div>
        </td>
    </tr>
    @endforelse
</tbody>

        </table>
    </div>
</div>



        @if($selectedDate)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-opacity-60 backdrop-blur-sm">
            <div class="w-11/12 md:w-4/5 lg:w-3/4 max-w-4xl bg-white rounded-xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden">
                <!-- Header - Always visible -->
    <!-- Header - Always visible -->
    <div class="sticky top-0 z-10 flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
        <!-- Left side with navigation and date display -->
        <div class="flex items-center space-x-2">
            <!-- Previous button -->
            <button
                wire:click="goPrevious"
                @if(! $this->previousDate()) disabled @endif
                class="p-2 rounded-full hover:bg-gray-100 disabled:opacity-50"
                title="Previous day"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Date display -->
            <h3 class="flex items-center text-xl font-semibold text-gray-800 gap-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
                <span>Details of: <span class="text-blue-600">{{ \Carbon\Carbon::parse($selectedDate)->format('d/m/Y') }}</span></span>
            </h3>

            <!-- Next button -->
            <button
                wire:click="goNext"
                @if(! $this->nextDate()) disabled @endif
                class="p-2 rounded-full hover:bg-gray-100 disabled:opacity-50"
                title="Next day"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <!-- Right side with close button -->
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
                                            <th class="px-4 py-3 font-medium text-center text-gray-700">SALES</th>
                                            <th class="px-4 py-3 font-medium text-center text-gray-700">VALUE IN</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($facturesOfDay as $facture)
                                            <tr class="border-t border-gray-200 hover:bg-gray-50">
                                                <td class="px-4 py-3 text-center text-gray-800">
                                                    <span >

                                                    <a wire:navigate href="{{ route('editfacture', ['edit' => $facture->id]) }}"
                                                        class="inline-flex items-center justify-center gap-x-1 rounded-md text-base font-medium ring-1 ring-inset px-2 py-1 min-w-[1.5rem]  whitespace-nowrap cursor-pointer">
                                                        #{{ $facture->id }}
                                                     </a>
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
                                                    <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-base font-medium ring-1 ring-inset ring-blue-600/10 px-2 py-1 min-w-[1.5rem] bg-blue-50 text-blue-600 whitespace-nowrap">
                                                    {{ number_format($facture->total_amount,2,',',' ') }} DA
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-base font-medium ring-1 ring-inset ring-green-600/10 px-2 py-1 min-w-[1.5rem] bg-green-50 text-green-600 whitespace-nowrap">
                                                    {{ number_format($facture->paid_value,2,',',' ') }} DA
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
                                            <td colspan="3" class="px-4 py-3 text-lg text-right border-t">TOTAL OF :</td>
                                            <td class="px-4 py-3 text-center">
                                                <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-lg font-medium ring-1 ring-inset ring-blue-600/30 px-2 py-1 min-w-[1.5rem] bg-blue-50 text-blue-800 whitespace-nowrap">
                                                    {{ number_format($inflow, 2, ',', ' ') }} DA
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-lg font-medium ring-1 ring-inset ring-green-600/30 px-2 py-1 min-w-[1.5rem] bg-green-50 text-green-800 whitespace-nowrap">
                                                    {{ number_format($facturesOfDay->sum('paid_value'), 2, ',', ' ') }} DA
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
                                                    <a wire:navigate href="{{ route('editdeponse', ['id' => $mvt->id]) }}"
                                                        class="inline-flex items-center justify-center gap-x-1 rounded-md text-base font-medium ring-1 ring-inset px-2 py-1 min-w-[1.5rem] whitespace-nowrap cursor-pointer">
                                                        #{{ $mvt->id }}
                                                    </a>
                                                </td>

                                                <td class="px-4 py-3 text-center text-gray-800">
                                                    <span class=" inline-block max-w-[20ch] truncate items-center justify-center gap-x-1 rounded-md text-base font-medium ring-1 ring-inset ring-yellow-600/10 px-2 py-1 min-w-[1.5rem] bg-yellow-50 text-yellow-600 whitespace-nowrap">
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
                                + {{ number_format($facturesOfDay->sum('paid_value'), 2, ',', ' ') }} DA                                </span>
                            </div>
                            <div class="flex items-center justify-between px-4 py-3">
                                <span class="font-semibold text-gray-700">Total Cash Out</span>
                                <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-base font-bold ring-1 ring-inset ring-red-600/10 px-2 py-1 min-w-[1.5rem] bg-red-50 text-red-800 whitespace-nowrap">
                                - {{ number_format(collect($mouvementsOfDay)->sum('montant'), 2, ',', ' ') }} DA</span>
                            </div>
                            <div class="flex items-center justify-between px-4 py-3 bg-gray-50">
                                <span class="font-medium text-gray-800">Expected Final Balance</span>
                                <span class="text-lg inline-flex items-center justify-center gap-x-1 rounded-md  font-bold ring-1 ring-inset ring-green-600/10 px-2 py-1 min-w-[1.5rem] bg-green-50 text-green-800 whitespace-nowrap">
                                    {{ number_format($dailyBalances[$selectedDate]['start'] + $facturesOfDay->sum('paid_value') - collect($mouvementsOfDay)->sum('montant'), 2, ',', ' ') }} DA</span>
                            </div>
                        </div>
                    </div>

    <!-- CASH COUNT & BALANCING (pure Alpine.js) -->
    <div
        x-data="{
            start: {{ $dailyBalances[$selectedDate]['start'] ?? 0 }},
            paidIn: {{ $facturesOfDay->sum('paid_value') ?? 0 }},
            cashOut: {{ collect($mouvementsOfDay)->sum('montant') ?? 0 }},
            get total() { return this.start + this.paidIn - this.cashOut },
            actual: @entangle('actualCashCount'),
            get decalage() { return this.actual - this.total },
            percent() { return Math.min(Math.abs(this.decalage / (this.total || 1) * 100), 100) }
        }"
        class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-md"
    >
        <!-- Header -->
        <div class="px-5 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
            <h3 class="text-lg font-semibold text-gray-800">CASH COUNT & BALANCING</h3>
        </div>

        <div class="p-5">
            <!-- Main Input Section -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Expected Balance (Read-only) -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Expected Balance</label>
                    <span
                    class="inline-flex items-center justify-center px-4 py-3 text-2xl font-bold text-blue-800 transition-colors bg-blue-100 rounded-md"
                    x-text="total.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                            + ' DA'">
                    </span>
                    <p class="mt-1.5 text-xs text-gray-500">Calculated from start value, cash in, and cash out</p>
                </div>

                <!-- Actual Cash Count (Editable) -->
                <div>
                    <label for="actual-cash-count" class="block mb-2 text-sm font-medium text-gray-700">
                        Actual Cash Count
                    </label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <span class="px-2 py-1 text-2xl font-bold text-blue-800 bg-blue-100 rounded-md">DA</span>
                        </div>
                        <input
                            id="actual-cash-count"
                            class="block w-full py-3 pl-10 pr-16 text-2xl font-semibold transition-colors bg-white border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                            type="number"
                            step="100"
                            x-model.number="actual"
                            @input.debounce.300ms="$wire.updateDecalage(actual)"
                        />
                    </div>
                    <p class="mt-1.5 text-xs text-gray-500">Enter the exact amount you count in the cash box</p>
                </div>
            </div>

            <!-- Discrepancy Section -->
            <div class="p-4 mt-6 border border-gray-200 rounded-lg md:col-span-2 bg-gray-50">
                <div>
                    <div class="flex items-center justify-between">
                        <div class="max-w-xs">
                            <h5 class="text-base font-semibold text-gray-800">Discrepancy (Décalage)</h5>
                            <p class="text-xs text-gray-500">Difference between expected and actual cash</p>
                        </div>
                        <div>
                            <span
                                class="inline-flex items-center justify-center px-4 py-2 text-xl font-bold transition-colors rounded-md"
                                :class="decalage < 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'"
                                x-text="(decalage >= 0 ? '+' : '')
                                        + decalage.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                                        + ' DA'"
                            ></span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="flex items-center mt-4">
                        <div class="w-full h-3 overflow-hidden bg-gray-200 rounded-full">
                            <div
                                class="h-3 transition-all duration-300 ease-in-out rounded-full"
                                :class="decalage < 0 ? 'bg-red-500' : 'bg-green-500'"
                                :style="{ width: percent() + '%' }"
                            ></div>
                        </div>
                    </div>

                    <!-- Percentage Display -->
                    <p
                        class="mt-2 text-sm font-medium"
                        :class="decalage < 0 ? 'text-red-600' : 'text-green-600'"
                        x-text="(decalage >= 0 ? '+' : '') +
                            (decalage / total * 100).toFixed(2) + '%'"
                    ></p>
                </div>
            </div>

            <!-- Leftover for Next Day -->
            <div class="mt-6">
                <label for="next-day-balance" class="block mb-2 text-sm font-medium text-gray-700">
                    START NEXT DAY
                </label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                        <span class="px-2 py-1 text-2xl font-bold text-blue-800 bg-blue-100 rounded-md">DA</span>
                    </div>
                    <input
                        id="next-day-balance"
                        class="block w-full py-3 pl-10 pr-16 text-2xl font-medium transition-colors bg-white border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        type="number"
                        step="100"
                        wire:model.defer="nextStartValue"
                    />
                </div>
                <p class="mt-1.5 text-xs text-gray-500">This becomes tomorrow's opening balance</p>
            </div>
        </div>

        <!-- Footer with Save Button -->
        <div class="flex justify-end px-6 py-4 border-t border-gray-200 bg-gray-50">
            <button
                @click.prevent="$wire.saveEndValue()"
                class="flex items-center justify-center gap-2 px-6 py-3 font-medium text-white transition-transform duration-100 ease-in-out bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 active:scale-90 group"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white transition duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
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
        @endif
      </div>



</div>
<script>
    function cashData() {
      return {
        // entangle these with your Livewire props!
        total: @entangle('total'),
        actual: @entangle('actualCashCount'),

        // difference
        get decalage() {
          return this.actual - this.total;
        },

        // raw percentage, can go negative or exceed 100
        rawPercent() {
          return (this.decalage / this.total) * 100;
        },

        // clamped 0–100 for bar width
        widthPercent() {
          return Math.min(Math.abs(this.rawPercent()), 100);
        }
      };
    }
  </script>
