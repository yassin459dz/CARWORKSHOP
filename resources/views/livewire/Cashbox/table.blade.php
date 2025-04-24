<div class="py-6">
    <h2 class="mb-4 text-2xl font-semibold">Historique de la caisse</h2>

    {{-- Filtre par date --}}
    <div class="flex gap-4 mb-6">
        <div>
            <label for="from" class="block text-sm">Du</label>
            <input type="date" wire:model.debounce.500ms="searchDateFrom" id="from"
                   class="px-2 py-1 border rounded">
        </div>
        <div>
            <label for="to" class="block text-sm">Au</label>
            <input type="date" wire:model.debounce.500ms="searchDateTo" id="to"
                   class="px-2 py-1 border rounded">
        </div>
    </div>

    {{-- Tableau --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="w-full text-sm text-gray-700">
            <thead class="text-xs uppercase bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Type</th>
                    <th class="px-4 py-2">Montant</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Facture liée</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mouvements as $m)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($m->date)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded
                                {{ $m->type === 'ENTRÉE'
                                   ? 'bg-green-100 text-green-800'
                                   : 'bg-red-100 text-red-800' }}">
                                {{ $m->type }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ number_format($m->montant, 2, ',', ' ') }} DA</td>
                        <td class="px-4 py-2">{{ $m->description }}</td>
                        <td class="px-4 py-2">
                            @if($m->facture)
                                <a href="{{ route('viewfacture', $m->facture->id) }}"
                                   class="text-blue-600 hover:underline">
                                    #{{ $m->facture->id }}
                                </a>
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                            Aucun mouvement trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $mouvements->links() }}
    </div>
</div>
