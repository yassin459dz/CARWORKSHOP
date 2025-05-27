<!-- Client View Modal -->
<div wire:ignore.self data-modal-target="modalEl" id="modalEl" tabindex="-1" class="fixed inset-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4">
    <div class="relative w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-900">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 rounded-t-2xl dark:border-gray-700 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-gray-800 dark:to-gray-900">
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-center w-14 h-14 bg-blue-200 rounded-full dark:bg-blue-700">
                        <svg class="w-8 h-8 text-blue-700 dark:text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $name }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Full client profile and information</p>
                    </div>
                </div>
                <button
            data-modal-toggle="modalEl" type="button"
            class="absolute text-gray-600 top-6 right-6 hover:text-red-700"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 bg-white dark:bg-gray-900">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Client Info Card -->
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-5 shadow-sm flex flex-col gap-4">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                            </svg>
                            <span class="font-semibold text-gray-800 dark:text-white">{{ $phone ?? 'No phone' }}<span class="font-semibold text-gray-800 dark:text-white"> - {{ $phone2 }}</span></span>
                        </div>

                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2h2v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l1.293 1.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            <span class="font-semibold text-gray-800 dark:text-white">Address : {{ $address }}</span>
                        </div>
                    </div>
                    <!-- Sold Status Card -->
                    <div class="flex flex-col gap-4 justify-between">
                        <div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Sold Status</span>
                            @php
                                $sold = $sold ?? 0;
                                $status = $sold < 0 ? 'Debt' : ($sold > 0 ? 'Credit' : 'Settled');
                                $badgeColor = $sold < 0 ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200' : ($sold > 0 ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200');
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 mt-2 rounded-full text-sm font-semibold {{ $badgeColor }}">
                                {{ $status }}
                                <span class="ml-2 font-mono">{{ number_format($sold, 2) }}</span>
                            </span>
                        </div>
                        <div class="mt-4">
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Client Since</span>
                            <div class="text-gray-800 dark:text-gray-100 font-semibold mt-1">{{ $date }}</div>
                        </div>
                    </div>
                </div>

                <!-- Remarks Section (Full Width) -->
                <div class="mt-8">
                    <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                        </svg>
                        Remarks
                    </label>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 text-gray-700 dark:text-gray-200 min-h-[60px]">
                        {{ $remark ?? 'No remarks.' }}
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex flex-col md:flex-row items-center justify-between p-6 gap-4 border-t border-gray-200 rounded-b-2xl dark:border-gray-700 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-gray-800 dark:to-gray-900">
                <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                    <span class="font-medium">Last updated:</span>
                    <span class="font-mono">{{ $updated }}</span>
                </div>
                <div class="flex gap-2">
                    <button type="button" wire:click="editClient" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-semibold shadow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536M9 13l6-6M4 20h7a2 2 0 002-2v-7a2 2 0 00-2-2H4a2 2 0 00-2 2v7a2 2 0 002 2z"></path></svg>
                        Edit
                    </button>
                    <button type="button" wire:click="deleteClient" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition font-semibold shadow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                        Delete
                    </button>
                    <button data-modal-toggle="modalEl" type="button" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition font-semibold shadow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

<div class="w-full  max-w-5xl bg-white rounded-t-3xl ">
  <!-- Header -->
  <div class="bg-gradient-to-r rounded-t-2xl from-slate-800 to-slate-700 px-8 py-4 flex items-center justify-between">
    <div class="flex items-center space-x-4">
      <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center ring-2 ring-white/20">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-6">
  <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
</svg>

      </div>
      <div>
        <h1 class="text-xl font-semibold text-white">{{ $name }}</h1>
        <p class="text-sm text-slate-300">Full client profile and information</p>
      </div>
      
    </div>
    
    <button
            data-modal-toggle="modalEl" type="button"
            class="absolute text-gray-600 p-1 top-14 right-10 hover:text-red-700"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
  </div>

  <!-- Content -->
  <div class="p-8 space-y-6">
    <!-- Top Row -->
    <div class="flex justify-between items-start">
      <div class="space-y-4 flex-1 max-w-md">
        <!-- Status and Credit -->
        <div class="flex justify-between items-center">
          <span class="text-slate-600 font-medium">Sold : </span>
          <span class="bg-emerald-50 text-emerald-700 px-4 py-1.5 rounded-full text-sm font-semibold ring-1 ring-emerald-100">
            @if($sold < 0)
            Debt
            @elseif($sold > 0)
            Credit
            @else
            Settled
            @endif
            {{ number_format($sold, 2) }} DA
          </span>
        </div>
        <!-- Contact Information -->
        <div class="space-y-3">
          <div class="flex items-center space-x-3 p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
          <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                            </svg>            <span class="text-slate-700 font-medium">{{ $phone ?? 'No phone' }} - {{ $phone2 ?? 'No phone2' }}</span>
          </div>
          <div class="flex items-center space-x-3 p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
          <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2h2v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l1.293 1.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>            <span class="text-slate-700 font-medium">Address: {{ $address ?? 'No address' }}</span>
          </div>
        </div>
      </div>
      <!-- Client Since -->
      @if(isset($client) && isset($client->created_at))
    <div class="bg-slate-50 p-4 rounded-lg ml-8 w-64" x-data="clientDuration('{{ $client->created_at->toISOString() }}')" x-init="init()">
        <div class="text-sm text-slate-500 font-medium">Client Since</div>
        <div class="text-slate-800 font-semibold mt-1" id="client-since">{{ $date }}</div>
        <div class="text-sm text-slate-500 font-medium">Duration</div>
        <div class="text-slate-800 font-semibold mt-1" x-text="duration"></div>
    </div>
    @endif
        <!-- Remarks Section -->
        <div class="border-t border-slate-200 pt-6">
      <div class="flex items-center space-x-2 mb-3">
        <i data-lucide="message-circle" class="w-5 h-5 text-slate-500"></i>
        <span class="text-slate-600 font-semibold">Remarks</span>
      </div>
      <div class="bg-slate-50 p-4 rounded-lg">
        <p class="text-slate-700">{{ $remark ?? 'No remarks.' }}</p>
      </div>
    </div>
    </div>


    <!-- Remarks Section -->
    <div class="border-t border-slate-200 pt-6">
      <div class="flex items-center space-x-2 mb-3">
        <i data-lucide="message-circle" class="w-5 h-5 text-slate-500"></i>
        <span class="text-slate-600 font-semibold">Remarks</span>
      </div>
      <div class="bg-slate-50 p-4 rounded-lg">
        <p class="text-slate-700">{{ $remark ?? 'No remarks.' }}</p>
      </div>
    </div>
  </div>

  <!-- Footer Actions -->
  <div class="bg-slate-50 px-8 py-4 flex items-center justify-between border-t border-slate-200">
    <div class="text-sm text-slate-500">Last updated: {{ $updated }}</div>
    <div class="flex space-x-3">
    <button type="button" wire:click="editClient" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-semibold shadow">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536M9 13l6-6M4 20h7a2 2 0 002-2v-7a2 2 0 00-2-2H4a2 2 0 00-2 2v7a2 2 0 002 2z"></path></svg>
        Edit
    </button>
    <button type="button" wire:click="deleteClient" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition font-semibold shadow">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
        Delete
    </button>
    </div>
  </div>
</div>

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

</div>
