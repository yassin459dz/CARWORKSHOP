<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
    @if($factures->isNotEmpty())



    <div class="relative p-8 mb-6 overflow-hidden bg-gray-100 border-blue-600 dark:bg-gray-900 border-x-4 rounded-xl">
        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 w-40 h-40 rounded-full bg-blue-50 blur-3xl opacity-20"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 rounded-full bg-indigo-50 blur-3xl opacity-10"></div>

        <h1 class="relative">
            <!-- Main Title -->
            <div class="flex items-center gap-2 mb-3 text-base font-semibold tracking-wider text-blue-600 uppercase">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="text-xl font-bold text-black tracking-wider uppercase">Facture History</span>
            </div>

            <!-- Client Details -->
            <div class="flex items-center text-2xl gap-x-4 overflow-x-auto pb-2 whitespace-nowrap">
                <div class="flex items-center gap-2 group">
                    <span class="text font-semibold tracking-wider  uppercase dark:text-gray-300">Client</span>
                    <span class="inline-flex items-center justify-center px-2 py-1 text-lg font-bold min-w-[2.5rem] text-blue-600 rounded-md gap-x-1 bg-green-50 ring-1 ring-inset ring-blue-600/10 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/30">
                        {{ $matricule->client->name }}
                    </span>
                </div>

                <div class="text-xl font-bold ">|</div>

                <div class="flex items-center gap-2 group">
                    <span class=" font-bold tracking-wider uppercase ">Car</span>
                    <span class="inline-flex items-center justify-center px-2 py-1 text-xl min-w-[2.5rem] font-bold text-blue-600 rounded-md gap-x-1 bg-green-50 ring-1 ring-inset ring-blue-600/10 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/30">
                        {{ $matricule->car->model }}
                    </span>
                </div>

                <div class="text-xl font-bold ">|</div>

                <div class="flex items-center gap-2 group">
                    <span class="text font-bold tracking-wider  uppercase ">Matricule</span>
                    <span class="inline-flex items-center justify-center px-2 py-1 text-xl min-w-[2.5rem] font-bold text-blue-600 rounded-md gap-x-1 bg-green-50 ring-1 ring-inset ring-blue-600/10 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/30">
                        {{ $matricule->mat }}
                    </span>
                </div>

                <div class="text-xl font-bold ">|</div>
                
                <div class="flex items-center gap-2 group">
                    <span class="text font-bold tracking-wider uppercase">Count</span>
                    <span class="inline-flex items-center justify-center px-2 py-1 text-xl font-bold min-w-[2.5rem] text-blue-600 rounded-md gap-x-1 bg-green-50 ring-1 ring-inset ring-blue-600/10 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/30">
                        {{ $matricule->factures_count }}
                    </span>
                </div>

                <div class="text-xl font-bold ">|</div>
                
                <div class="flex items-center gap-2 group">
                    <span class="text-xl font-bold tracking-wider uppercase">Sold</span>
                    <span class="inline-flex items-center justify-center px-2 py-1 text-xl font-bold min-w-[2.5rem] text-blue-600 rounded-md gap-x-1 bg-green-50 ring-1 ring-inset ring-blue-600/10 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/30">
                        {{ number_format($matricule->client->sold, 2, ',', ' ') }} DA
                    </span>
                </div>
            </div>
        </h1>
    </div>



    @else
    <h1 class="text-xl font-bold">
        Facture History for CLIENT : <span class="font-bold text-blue-600">{{ $matricule->client->name }}</span>
        CAR : <span class="font-bold text-blue-600">{{ $matricule->car->model }}</span>
        MATRICULE : <span class="font-bold text-blue-600">{{ $matricule->mat }}</span>
    </h1>
    @endif
</x-slot>
<div class="py-12 ">
    <div class="mx-auto mt-8 max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="text-gray-900 ">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    @if($factures->isNotEmpty())

                    <table class="w-full text-sm text-gray-700 text-centre dark:text-gray-400">
                        <thead class="text-xs font-semibold text-gray-900 uppercase bg-gray-100 dark:bg-gray-800 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-3 py-4 text-center">ID</th>
                                <th scope="col" class="px-6 py-4 text-center">DATE</th>
                                <th scope="col" class="px-6 py-4 text-center">KM</th>
                                <th scope="col" class="px-6 py-4 text-center">Remark</th>
                                <th scope="col" class="px-6 py-4 text-center">STATUS</th>
                                <th scope="col" class="px-6 py-4 text-center">Total</th>
                                <th scope="col" class="px-6 py-4 text-center">PAID VALUE</th>
                                <th scope="col" class="px-6 py-4 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($factures as $facture)
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-900 dark:even:bg-gray-800">
                                <td class="px-3 py-4 font-medium text-center text-gray-900 dark:text-white">#{{ $facture->id }}</td>
                                <td class="px-3 py-4 text-center" text-center>
                                    <span class="    inline-flex items-center justify-center
    gap-x-1
    rounded-md
    text-sm font-medium
    ring-1 ring-inset ring-gray-500
    px-2 py-1
    min-w-[1.5rem]
    bg-black-50 text-black-600
    dark:bg-black-400/10 dark:text-black-400 dark:ring-black-400/30
    whitespace-nowrap">{{ $facture->created_at->format('d-M-Y') }}</span>
                                    </td>
                                <td class="px-6 py-4 text-center ">
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
                                    whitespace-nowrap">{{ $facture->km }}
                                </span>
                                </td>
                                <td class="px-3 py-4 font-medium text-center text-gray-900 dark:text-white">{{ $facture->remark }}</td>
                                <td class="px-2 py-4 text-center">
                                    @php
    $paid = floatval($facture->paid_value ?? 0);
    $total = floatval($facture->total_amount ?? 0);
    $percent = $total > 0 ? round(($paid / $total) * 100) : 0;
    if ($paid == 0) {
        $status = 'NOT PAID';
        $color = 'bg-red-50 text-red-600 ring-red-600/10 dark:bg-red-400/10 dark:text-red-400 dark:ring-red-400/30';
        $icon = '<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 9.75l4.5 4.5M14.25 9.75l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
        $label = $status;
    } elseif ($paid == $total && $total > 0) {
        $status = 'PAID';
        $color = 'bg-blue-50 text-blue-600 ring-blue-600/10 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/30';
        $icon = '<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
        $label = $status;
    } elseif ($paid > 0 && $paid < $total) {
        $status = 'PARTIAL';
        $color = 'bg-orange-50 text-orange-700 ring-orange-600/10 dark:bg-orange-400/10 dark:text-orange-400 dark:ring-orange-400/30';
        $icon = '';
        $label = $percent.' %';
    } elseif ($paid > $total && $total > 0) {
        $status = 'OVERPAID';
        $color = 'bg-purple-50 text-purple-700 ring-purple-600/10 dark:bg-purple-400/10 dark:text-purple-400 dark:ring-purple-400/30';
        $icon = '';
        $label = $percent.' %';
    } else {
        $status = 'UNKNOWN';
        $color = 'bg-gray-50 text-gray-600 ring-gray-400/10';
        $icon = '';
        $label = $status;
    }
@endphp
<span class="inline-flex items-center justify-center gap-x-1 rounded-md text-sm font-medium ring-1 ring-inset px-2 py-1 min-w-[1.5rem] {{ $color }} whitespace-nowrap">
    {!! $icon !!}
    <span>{{ $label }}</span>
</span>

                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                    class="
                                        inline-flex items-center justify-center
                                        gap-x-1
                                        rounded-md
                                        text-sm font-medium
                                        ring-1 ring-inset ring-blue-600/10
                                        px-2 py-1
                                        min-w-[1.5rem]
                                      bg-blue-50 text-blue-600
                                      dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/30
                                        whitespace-nowrap"
                                    >
                                        {{ $facture->total_amount }} DA
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                    class="
                                        inline-flex items-center justify-center
                                        gap-x-1
                                        rounded-md
                                        text-sm font-medium
                                        ring-1 ring-inset ring-green-600/10
                                        px-2 py-1
                                        min-w-[1.5rem]
                                      bg-green-50 text-green-600
                                      dark:bg-green-400/10 dark:text-green-400 dark:ring-green-400/30
                                        whitespace-nowrap"
                                    >
                                    {{ number_format($facture->paid_value,2,',',' ') }} DA
                                    </span>
                                </td>
                                <td class="py-4 ">
                                    <a wire:navigate href="{{ route('viewfacture', ['id' => $facture->id]) }}"
                                       class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                       View
                                    </a>
                                    <a wire:navigate href="{{ route('editfacture', ['edit' => $facture->id]) }}"
                                       class="font-medium text-green-600 dark:text-green-500 hover:underline">
                                       Edit
                                    </a>

                                     <button data-modal-target="popup-modal-{{ $facture->id }}" data-modal-toggle="popup-modal-{{ $facture->id }}" class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                        Delete
                                        </button>
                                        <livewire:deletefacture :factureId="$facture->id" />
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination Links -->


                    <!-- If there are no clients -->
                     {{-- @if ($clients->isEmpty())
                        <p class="p-4 text-gray-500">No clients available.</p>
                    @endif --}}
                </div>

            </div>

        </div>

    </div>
        @else
        <h1 class="text-xl font-bold text-red-600">Facture Not Exist</h1>

        @endif
</div>


