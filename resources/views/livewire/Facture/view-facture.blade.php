
<div class="min-h-screen p-4 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    <div class="max-w-4xl mx-auto space-y-4">
        <div class="overflow-hidden bg-white rounded-lg shadow-md">
            <div class="p-4 text-white bg-gradient-to-r from-blue-600 to-indigo-600">
                <div class="flex items-start justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <div>
                            <h1 class="text-xl font-bold">Invoice #{{ $invoiceNumber }}</h1>
                            <p class="text-sm opacity-90">{{ $date }} - {{ $time }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
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
            $label = 'PAID : '.$percent.' %';
        } elseif ($paid > $total && $total > 0) {
            $status = 'OVERPAID';
            $color = 'bg-purple-50 text-purple-700 ring-purple-600/10 dark:bg-purple-400/10 dark:text-purple-400 dark:ring-purple-400/30';
            $icon = '';
            $label = 'PAID : '.$percent.' %';
        } else {
            $status = 'UNKNOWN';
            $color = 'bg-gray-50 text-gray-600 ring-gray-400/10';
            $icon = '';
            $label = $status;
        }
    @endphp
    <span class="inline-flex items-center justify-center gap-x-1 rounded-md text font-semibold ring-1 ring-inset px-2 py-1 min-w-[1.5rem] {{ $color }} whitespace-nowrap">
        {!! $icon !!}
        <span>{{ $label }}</span>
    </span>
    <td class="px-6 py-4 text-center">
                                    <span
                                    class="
    inline-flex items-center justify-center
    gap-x-1
    rounded-md
    text font-semibold
    ring-1 ring-inset ring-green-600/10
    px-2 py-1
    min-w-[1.5rem]
    bg-green-50 text-green-600
    dark:bg-green-400/10 dark:text-green-400 dark:ring-green-400/30
    whitespace-nowrap
  ">


  {{ number_format($facture->paid_value,2,',',' ') }} DA
                                    </span>
                                </td>


                    <div class="flex space-x-2">
                        <button
                            wire:click="print"
                            x-on:click="printPreview = true"
                            class="bg-white/20 hover:bg-white/30 p-1.5 rounded-lg">
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex space-x-2">
                        <a
                            href="{{ route('editfacture', ['edit' => $facture->id]) }}"
                            class="bg-white/20 hover:bg-white/30 p-1.5 rounded-lg">
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                                <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                        </a>
                    </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 p-4">
                <div class="p-3 rounded-lg bg-blue-50">
                    <div class="flex items-center mb-2 space-x-2">
                        <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <h2 class="font-medium text-xl text-blue-800">Client : <span>{{ $client['name'] }}</span> </h2>
                    </div>
                    <div class="flex items-center mt-8 space-x-2">
                        <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                          </svg>
                        <h2 class="font-medium text-blue-800 text-xl ">Phone :
                            <span>{{ $client['phone'] }}
                            @if (!empty($client['phone2']))
                                <span> - {{ $client['phone2'] }}
                                </span>
                            @endif
                            </span>
                        </h2>
                    </div>


                </div>
                <div class="pt-2 pl-6 rounded-lg bg-indigo-50">
                        <div>
                            <h2 class="font-semibold text-xl my-2 text-blue-800">Car : {{ $vehicle['model'] }}</h2>
                            <h2 class="font-semibold text-xl my-2 text-blue-800">Matricule : {{ $vehicle['matricule'] }}</h2>
                            <h2 class="font-semibold text-xl my-2 text-blue-800">KM : {{ number_format($vehicle['kilometers']) }}</h2>
                        </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div class="col-span-2 overflow-hidden bg-white rounded-lg shadow-md">
                <div class="flex items-center px-4 py-2 text-white bg-gradient-to-r from-blue-600 to-indigo-600">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <h2 class="font-medium">Order Items</h2>
                </div>
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="py-2 text-base text-left text-gray-900 ">Name</th>
                                    <th class="px-1 py-1 text-left text-gray-900 ext-base">Description</th>
                                    <th class="px-3 py-1 text-gray-900 ext-base">Qty</th>
                                    <th class="px-3 py-1 text-right text-gray-900 ext-base">Price</th>
                                    <th class="px-3 py-1 text-right text-gray-900 ext-base">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderItems as $item)
                                <tr class="border-t">
                                    <td class="py-1 pr-3 ">{{ $item['name'] }}</td>
                                    <td class="px-1 py-2">{{ $item['description'] }}</td>
                                    <td class="py-2 pl-6 ">{{ $item['quantity'] }}</td>
                                    <td class="px-2 py-2 text-right">{{ number_format($item['price'], 2) }}</td>
                                    <td class="py-2 pl-1 font-medium text-right">{{ number_format($item['total'], 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="p-4 bg-white rounded-lg shadow-md">
                <div class="space-y-2">
                    <div class="flex justify-between text-lg font-medium text-green-600 " style="font-size: 17.5px;" >
                        <span>Extra Charges</span>
                        <span>+{{ number_format($financial['extra_charge'], 2) }} DA</span>
                    </div>
                    <div class="flex justify-between text-lg font-medium text-red-600" style="font-size: 17.5px;">
                        <span>Discount :</span>
                        <span>-{{ number_format($financial['discount_amount'], 2) }} DA</span>
                    </div>
                    
                    <div class="flex justify-between text-xl font-bold text-blue-600 ">
                        <span>Total :</span>
                        <span>{{ number_format($financial['total_amount'], 2) }} DA</span>
                    </div>
                    <div class="flex justify-between text-xl font-bold  ">
                        <span>Sold :</span>
                        <span>                                
                          @php
                          $sold = $client['sold'] ?? 0;
                          $soldLabel = $sold < 0 ? 'Debt' : ($sold > 0 ? 'Credit' : 'Settled');
                          @endphp
                          {{ number_format($sold, 2, ',', ' ') }} DA </span>
                    </div>
                </div>
                <div class="pt-2 mt-2 border-t ">
                    
                    <div class="flex items-center mb-2 space-x-2">
                        <h2 class="text-lg font-medium text-gray-800">Remark :</h2>
                    </div>
                    <p class="text-base text-gray-800 rounded-lg bg-gray-50 ">{{ $remark }}</p>
                </div>
            </div>
        </div>
    </div>


    <div>
        <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('show-thermal-invoice-preview', (event) => {
                const printData = event[0] || event;

        const printWindow = window.open();

        if (!printWindow) {
            alert('Please allow pop-ups for this site to print invoices');
            return;
        }

                printWindow.document.write(`

      <style>
        @media print {
          @page {
            margin: 0;
            size: 80mm auto;
          }
          body {
            margin: 0;
            padding: 0;
            width: 80mm;
          }
          .screen-only {
            display: none !important;
          }
          * {
            margin: 0 !important;
            padding: 0 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
          }
          .no-break {
            break-inside: avoid;
          }
          * {
            color: black !important;
          }
          .rounded-lg, .rounded-full {
            border-radius: 0 !important;
          }
        }
        body {
          background: #f9fafb;
          font-family: Arial, sans-serif;
          line-height: 1.6;
        }
        .invoice-container {
          width: 80mm;
          margin: auto;
          background: #fff;
          padding: 8px;
          box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .header, .footer {
          text-align: center;
          border-bottom: 1px solid #ddd;
          padding-bottom: 8px;
          margin-bottom: 8px;
        }
        .order-items, .totals {
          width: 100%;
          border-collapse: collapse;
        }
        .order-items th, .order-items td, .totals td {
          text-align: left;
          padding: 4px 4px;
          border-bottom: 1px solid #ddd;
        }
         .total-row , .final-total{
            font-weight: bold !important;
        }
         .totals  {
            text-align: right;

        }
         .totals  th{
            font-weight: normal

        }

        .screen-only {
          text-align: right;
          margin-bottom: 16px;
        }
      </style>

      <div class="invoice-container" id="invoice">
        <div class="header">
          <h1 class="text-xl font-bold">INV #{{ $invoiceNumber }}</h1>
          <p id="date-time">{{ $date }} - {{ $time }}</p>
          <h3 id="status">{{ $status }}</h3>
        </div>
        <div>
          <p><strong>Client :</strong> {{ $client['name'] }}</p>
          <p><strong>Car :</strong> {{ $vehicle['model'] }}</p>
          <p><strong>Matricule :</strong> {{ $vehicle['matricule'] }}</p>
          <p><strong>KM :</strong> {{ number_format($vehicle['kilometers']) }}</p>
        </div>
        <table class="order-items">
          <thead>
            <tr>
              <th>Name</th>
              <th>Qty</th>
              <th>Price</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody id="order-items">
            <tbody>
                @foreach($orderItems as $item)
                <tr class="border-t">
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ number_format($item['price'], 2) }}</td>
                    <td>{{ number_format($item['total'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>          </tbody>
        </table>
        <table class="totals">
          <tr>
            <td>Extra Charges:</td>
            <th id="extra-charges">+{{ number_format($financial['extra_charge'], 2) }} DA</th>
          </tr>
          <tr>
            <td>Discount:</td>
            <th id="discount">-{{ number_format($financial['discount_amount'], 2) }} DA</th>
          </tr>
          <tr class="total-row">
            <td>Total:</td>
            <th id="final-total">{{ number_format($financial['total_amount'], 2) }} DA</th>
          </tr>
          <tr class="total-row">
            <td>Sold:</td>
            <th id="final-total">{{ number_format($sold, 2, ',', ' ') }} DA</th>
          </tr>
        </table>
        <div>
          <p><strong>Remarks:</strong></p>
          <p id="remarks">{{ $remark }}</p>
        </div>
        <div class="footer">
          <p>Thank you for your business!</p>
        </div>
      </div>
    `);

       printWindow.document.close();

        // Call the print method to directly show the print dialog
        printWindow.print();

    // Optionally, close the print window after printing
    printWindow.onafterprint = () => {
    printWindow.close();
        };
    });
});
</script>
</div>





</div>
