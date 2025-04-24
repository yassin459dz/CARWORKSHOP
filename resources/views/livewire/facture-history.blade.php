<div>
    <h1>Facture History for Client: {{ $factures->first()->client->name }} and Car: {{ $factures->first()->car->model }}</h1>

    <table class="w-full mt-4 border-collapse table-auto">
        <thead>
            <tr>
                <th class="px-4 py-2 border">Facture ID</th>
                <th class="px-4 py-2 border">KM</th>
                <th class="px-4 py-2 border">Total Amount</th>
                <th class="px-4 py-2 border">Extra Charge</th>
                <th class="px-4 py-2 border">Discount Amount</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($factures as $facture)
                <tr>
                    <td class="px-4 py-2 border">{{ $facture->id }}</td>
                    <td class="px-4 py-2 border">{{ $facture->km }}</td>
                    <td class="px-4 py-2 border">{{ number_format($facture->total_amount, 2) }}</td>
                    <td class="px-4 py-2 border">{{ number_format($facture->extra_charge, 2) }}</td>
                    <td class="px-4 py-2 border">{{ number_format($facture->discount_amount, 2) }}</td>
                    <td class="px-4 py-2 border">{{ $facture->status }}</td>
                    <td class="px-4 py-2 border">
                        <a href="{{ route('facture.show', $facture->id) }}" class="text-blue-500">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
