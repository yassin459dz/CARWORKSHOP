<!-- Client View Modal -->
<div wire:ignore.self data-modal-target="modalEl" id="modalEl" tabindex="-1" class="fixed inset-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4">


<div class="w-full max-w-4xl overflow-y-auto bg-white shadow-lg rounded-3xl dark:bg-slate-800">
  <!-- Header -->
  <div class="flex items-center justify-between px-8 py-4 bg-gradient-to-r rounded-t-2xl from-slate-800 to-slate-700 ">
    <div class="flex items-center space-x-4">
      <div class="flex items-center justify-center w-12 h-12 rounded-full bg-white/10 ring-2 ring-white/20">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-6">
  <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
</svg>

      </div>
      <div>
        <h1 class="text-xl font-semibold text-white">{{ $name }}</h1>
        <p class="text-sm text-slate-300">Full client profile and information</p>
      </div>

    </div>

    <button data-modal-toggle="modalEl" type="button" class="p-1 transition-colors rounded-lg text-white/80 hover:text-red-600 bg-white/10 hover:bg-white/30">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
      </svg>
    </button>
  </div>

  <!-- Content -->
<!-- Content -->
<div class="p-6 ">
    <!-- Header Section with Status -->
<div class="p-6 mb-6 bg-white border shadow-sm rounded-xl border-slate-200">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        {{-- Client Sold --}}
        <div class="flex items-center justify-center p-4 rounded-lg bg-slate-50">
            <h3 class="text-xl font-medium text-slate-700">Client Sold</h3>
            <span class="px-3 py-1.5 text-xl font-semibold rounded-full
                @if($sold < 0)
                     text-red-800
                @elseif($sold > 0)
                     text-green-800
                @else
                     text-slate-800
                @endif">
                @if($sold < 0) Negative
                @elseif($sold > 0) Credit
                @else No Sold
                @endif
                {{ number_format(abs($sold), 2) }} DA
            </span>
        </div>

        {{-- Facture Count --}}
        <div class="flex items-center justify-center p-4 rounded-lg bg-slate-50">
            <h3 class="text-xl font-medium text-slate-700">Facture Count</h3>
            <span class="px-3 py-1.5 text-xl font-semibold  text-blue-800 ">
                {{ $factureCount }}
            </span>
        </div>
    </div>
</div>


    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-2">
        <!-- Contact Information Card -->
        <div class="p-6 bg-white border shadow-sm rounded-xl border-slate-200">
            <h4 class="flex items-center mb-4 text-lg font-semibold text-slate-800">
                <svg class="w-5 h-5 mr-2 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Contact Information
            </h4>

            <div class="space-y-3">
                <div >
                    <div>
                        <div class="p-3 rounded-lg bg-blue-50">
                        <div class="text-base font-medium text-blue-600">Phone Numbers</div>
                    <div class="text-lg font-semibold text-blue-800" id="client-since">{{ $phone ?? 'Not provided' }}</div>
                    @if($phone2)
                        <div class="text-base font-medium text-blue-600"></div>
                        <div class="text-lg font-semibold text-blue-800" id="client-since">{{ $phone2 }}</div>
                    @endif
                    </div>

                    </div>
                </div>

                <div >
                        <div class="p-3 rounded-lg bg-green-50">
                        <div class="text-base font-medium text-green-600">Address</div>
                    <div class="text-lg font-semibold text-green-800" id="client-since">{{ $address ?? 'Not provided' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Client Duration Card -->
        @if(isset($client) && isset($client->created_at))
        <div class="p-6 bg-white border shadow-sm rounded-xl border-slate-200">
            <h4 class="flex items-center mb-4 text-lg font-semibold text-slate-800">
                <svg class="w-5 h-5 mr-2 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Client History
            </h4>

            <div class="space-y-4" x-data="clientDuration('{{ $client->created_at->toISOString() }}')" x-init="init()">
                <div class="p-3 rounded-lg bg-blue-50">
                    <div class="text-base font-medium text-blue-600">Member Since</div>
                    <div class="text-lg font-semibold text-blue-800" id="client-since">{{ $date }}</div>
                </div>

                <div class="p-3 rounded-lg bg-green-50">
                    <div class="text-base font-medium text-green-600">Duration</div>
                    <div class="text-lg font-semibold text-green-800" x-text="duration"></div>
                </div>
                        <div class="p-3 rounded-lg bg-red-50">
                    <div class="text-base font-medium text-red-600">Last Updated</div>
                    <div class="text-lg font-semibold text-red-800" >{{ $updated }}</div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Remarks Section - Full Width at Bottom -->
    <div class="p-6 bg-white border shadow-sm rounded-xl border-slate-200">
        <h4 class="flex items-center mb-4 font-semibold text-md text-slate-800">
            <svg class="w-5 h-5 mr-2 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
            </svg>
            Remarks & Notes
        </h4>

        <div class="p-4 border rounded-lg bg-amber-50 border-amber-200">
            <p class="leading-relaxed text-slate-700">
                {{ $remark ?? 'No remarks or notes have been added for this client.' }}
            </p>
        </div>
    </div>
</div >

  <!-- Footer Actions -->
  <div class="flex items-center justify-end px-8 py-4 border-t rounded-b-3xl bg-slate-50 border-slate-200">
    <div class="flex space-x-3 left-4">
    <button type="button" wire:click="editClient" class="inline-flex items-center gap-2 px-4 py-2 font-semibold text-white transition bg-blue-600 rounded-lg shadow hover:bg-blue-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536M9 13l6-6M4 20h7a2 2 0 002-2v-7a2 2 0 00-2-2H4a2 2 0 00-2 2v7a2 2 0 002 2z"></path></svg>
        Edit
    </button>
    <button type="button" wire:click="deleteClient" class="inline-flex items-center gap-2 px-4 py-2 font-semibold text-white transition bg-red-600 rounded-lg shadow hover:bg-red-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
        Delete
    </button>
    </div >
  </div >
</div >

<script>

    function clientDuration(clientSinceDate) {
        return {
            duration: 'Calculating...',
            init() {
                const start = new Date(clientSinceDate);
                const now = new Date('2025-05-27T23:57:25+01:00'); // Use server-provided current time
                let years = now.getFullYear() - start.getFullYear();
                let months = now.getMonth() - start.getMonth();
                let days = now.getDate() - start.getDate();

                if (days < 0) {
                    months--;
                    // Get days in previous month
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

</div >
