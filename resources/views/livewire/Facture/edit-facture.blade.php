<div
x-data="orderApp(@js($product))"
x-init="() => {
    console.log('Initializing Alpine.js...');

    if (@js($orderItems)) {
                console.log('Order Items:', @js($orderItems));

        orderItems = JSON.parse(@js($orderItems));
        extraCharge = @js($extraCharge);
        discountAmount = @js($discountAmount);
    }
}"
class="mx-auto max-w-7xl"
>
    <form wire:submit.prevent="update">
        <div class="bg-white shadow-2xl rounded-xl">
            <div class="flex flex-col md:flex-row">
                <!-- Left Section: Product List (mostly unchanged) -->
                <div class="relative w-full p-6 md:w-3/5 bg-gray-50">
                    <!-- THIS HOW TO CALL THE SEARCH AND CREATE A NEW PRODUCT -->
                <div wire:ignore>
                    <livewire:product-header />
                </div>
                <!-- THIS HOW TO CALL THE SEARCH AND CREATE A NEW PRODUCT -->

                    {{-- THE OLD DESIGN --}}
                    {{-- <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 overflow-y-scroll no-scrollbar max-h-[100vh]">
                        <template x-for="product in filteredProducts" :key="product.id">
                            <div
                                class="p-4 text-center transition duration-300 transform bg-white border border-gray-200 rounded-lg cursor-pointer hover:scale-105 hover:shadow-lg"
                                @click="addToOrder(product)">
                                <div class="mb-3 ">
                                    <h3 class="text-lg font-semibold text-gray-800" x-text="product.name"></h3>
                                    <p class="font-bold text-blue-600" x-text="product.description"></p>
                                </div>
                                <div class="text-xl font-semibold text-red-500" x-text="`${product.price} DA`"></div>
                            </div>
                        </template>
                    </div> --}}
                    {{-- THE OLD DESIGN --}}
                    <div class="grid max-h-screen grid-cols-1 gap-4 p-3 overflow-y-auto sm:grid-cols-2 lg:grid-cols-3 smooth-scroll">
                        <template x-for="product in filteredProducts" :key="product.id">
                            <div
                                @click="$wire.currentstep === 3 ? addToOrder(product) : null"
                                :class="[
    'flex flex-col p-6 bg-white border shadow-md rounded-2xl select-none group ',
    $wire.currentstep === 3
        ? 'cursor-pointer border-gray-100 hover:shadow-xl hover:-translate-y-1 active:scale-90 transition-transform duration-100 ease-in-out dark:bg-gray-900 dark:border-gray-800'
        : 'cursor-not-allowed bg-gray-100 opacity-70 border-gray-100'
]"
                            >
                                <!-- Product Name -->
                                <h3 class="mb-2 text-lg font-bold text-center text-gray-800 capitalize" x-text="product.name"></h3>

                                <!-- Description Badge -->
                                <span class="self-center px-3 mb-2 text-[15px] font-medium text-red-600 bg-gray-100 rounded-full" x-text="product.description"></span>

                                <!-- Price -->
                                <div class="mt-auto text-center">
                                    <span class="text-lg font-bold text-blue-600" x-text="`${product.price}.00 DA`"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Right Section: Order Summary -->
                <div class="w-full p-6 bg-white md:w-2/5">
                    <!-- Client Selection (Livewire Step 1) -->
                    @if($currentstep === 1)
                    <div class="mb-6">
                    {{-------------------------------Client START----------------------------}}
<div class="relative max-w-sm">
<div class="relative max-w-sm">
    <label for="client" class="block text-base font-medium text-gray-700">Client Name</label>
    <div class="flex items-center space-x-0 mt-2">
        <div x-data="{ 
            search: @js($search), 
            open: false,
            selectedClient: @entangle('client_id'),
            allClients: @js($allclients),
            init() {
                this.$watch('selectedClient', (value) => {
                    if (value) {
                        // Update search field with selected client name
                        const client = this.allClients.find(c => c.id == value);
                        if (client) {
                            this.search = client.name;
                        }
                    } else {
                        this.search = '';
                    }
                });
            }
        }" class="relative w-full">
            <!-- Searchable Input -->
            <input
                id="NewClient"
                type="text"
                x-model="search"
                class="block w-full p-2 text-gray-800 placeholder-gray-400 bg-white border-gray-300 rounded-l-lg focus:ring-blue-500 focus:outline-none"
                placeholder="Client"
                @focus="open = true"
                @input.debounce.100ms="open = true"
                autocomplete="off"
            />

            <!-- Dropdown -->
            <div class="absolute z-50 w-full mt-1.5 bg-white border border-gray-200 rounded-lg shadow-lg smooth-scroll"
                 x-show="open && search.length > 0"
                 @click.away="open = false">
                <div class="overflow-hidden overflow-y-auto max-h-72">
                    <template x-for="client in allClients.filter(c => c.name.toLowerCase().includes(search.toLowerCase()))" :key="client.id">
                        <div
                            class="flex items-center w-full px-4 py-2 text-sm text-gray-800 cursor-pointer hover:bg-blue-600 hover:text-white"
                            @click="
                                search = client.name;
                                selectedClient = client.id;
                                open = false;
                                // Dispatch event to reset car and matricule
                                $dispatch('client-changed', { clientId: client.id });
                            "
                        >
                            <span x-text="client.name"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Button on the right side -->
        <div>
            <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" type="button"
                    class="px-2.5 py-2 text-white bg-blue-700 hover:bg-blue-800 border-l border-gray-300 rounded-r-lg focus:ring-4 focus:outline-none focus:ring-blue-300"
                    @click="console.log('Authentication modal triggered')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </button>
            <div wire:ignore>
                    <livewire:create-edit-client />
                </div>
        </div>
    </div>
    @error('client_id')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-------------------------------Client END----------------------------}}



{{-------------------------------CAR START----------------------------}}
<label for="carSelect" class="block mt-2 pb-2 text-base font-medium text-gray-700">CAR</label>
<div class="flex items-center space-x-0">
    <div x-data="{ 
        carSearch: @js($facture && $facture->car ? $facture->car->model : ''), 
        carOpen: false,
        selectedClient: @entangle('client_id'),
        selectedCar: @entangle('car_id'),
        allCars: @js($allcars),
        allMatricules: @js($allmat),
        filteredCars: [],
        init() {
            // Initialize filtered cars
            this.updateFilteredCars();
            
            // Watch for client changes
            this.$watch('selectedClient', (value) => {
                this.updateFilteredCars();
                // Reset car selection when client changes (except when editing existing facture)
                if (!@js($factureId)) {
                    this.carSearch = '';
                    this.carOpen = false;
                }
            });
            
            // Watch for car changes (including auto-selection from Livewire)
            this.$watch('selectedCar', (value) => {
                if (value) {
                    // Update search field with selected car name
                    const car = this.allCars.find(c => c.id == value);
                    if (car) {
                        this.carSearch = car.model;
                    }
                    // Trigger matricule filtering
                    this.$dispatch('car-changed', { carId: value, clientId: this.selectedClient });
                } else {
                    this.carSearch = '';
                    this.$dispatch('car-changed', { carId: null, clientId: this.selectedClient });
                }
            });
        },
        updateFilteredCars() {
            if (!this.selectedClient) {
                this.filteredCars = [];
                return;
            }
            
            // Get owned car IDs for the selected client
            const ownedCarIds = this.allMatricules
                .filter(mat => mat.client_id == this.selectedClient)
                .map(mat => mat.car_id);
            
            // Separate owned and non-owned cars
            const ownedCars = this.allCars.filter(car => ownedCarIds.includes(car.id));
            const nonOwnedCars = this.allCars.filter(car => !ownedCarIds.includes(car.id));
            
            this.filteredCars = [
                { group: 'Owned Car', cars: ownedCars, groupClass: 'text-green-600', borderClass: 'border-l-4 border-green-400' },
                { group: 'Non Owned Car', cars: nonOwnedCars, groupClass: 'text-red-600', borderClass: 'border-l-4 border-red-400' }
            ];
        }
    }" 
    @client-changed.window="
        // Reset car selection when client changes
        selectedCar = null;
        carSearch = '';
        carOpen = false;
        updateFilteredCars();
    "
    class="relative w-full">
        <!-- Searchable Input -->
        <input
            id="carSearchInput"
            type="text"
            x-model="carSearch"
            class="block w-full p-2 text-gray-800 placeholder-gray-400 bg-white border border-gray-300 rounded-l-lg focus:ring-blue-500 focus:outline-none"
            placeholder="Search Car"
            @focus="carOpen = true"
            @click="carOpen = true"
            @input.debounce.100ms="carOpen = true"
            @click.away="carOpen = false"
            :disabled="!selectedClient"
            autocomplete="off"
        />

        <!-- Dropdown -->
        <div class="absolute z-40 w-full mt-1.5 bg-white border border-gray-200 rounded-lg shadow-lg"
             x-show="carOpen && selectedClient && filteredCars.length > 0">
            <div class="overflow-hidden overflow-y-auto max-h-72 smooth-scroll">
                <template x-for="group in filteredCars" :key="group.group">
                    <div x-show="group.cars.length > 0">
                        <!-- Group Header -->
                        <div class="px-4 py-2 text-xs font-semibold bg-gray-100 border-b" :class="group.groupClass" x-text="group.group"></div>
                        
                        <!-- Group Items -->
                        <template x-for="car in group.cars" :key="car.id">
                            <div
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-800 cursor-pointer hover:bg-blue-600 hover:text-white"
                                :class="group.borderClass"
                                x-show="carSearch === '' || car.model.toLowerCase().includes(carSearch.toLowerCase())"
                                @click="
                                    carSearch = car.model;
                                    carOpen = false;
                                    selectedCar = car.id;
                                "
                            >
                                <span x-text="car.model"></span>
                            </div>
                        </template>
                    </div>
                </template>
                
                <!-- No results message -->
                <div x-show="carSearch !== '' && !filteredCars.some(group => group.cars.some(car => car.model.toLowerCase().includes(carSearch.toLowerCase())))" 
                     class="px-4 py-2 text-sm text-gray-500">
                    No cars found
                </div>
            </div>
        </div>

        <!-- Hidden Select (for wire:model compatibility) -->
        <select id="carSelect" wire:model.live="car_id" wire:key="carSelect" class="hidden">
            <option wire:key="car-select-default" value=""></option>
            @foreach ($groupedCars as $groupLabel => $cars)
                <optgroup wire:key="group-{{ $groupLabel }}" label="{{ $groupLabel }}">
                    @foreach ($cars as $car)
                        <option wire:key="car-option-{{ $car->id }}" value="{{ $car->id }}">{{ $car->model }}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
    </div>

    <!-- Create Car Button -->
    <button
        type="button"
        @click="console.log('Car button clicked')"
        data-modal-target="authentication-modal"
        data-modal-toggle="authentication-modal"
        class="px-2.5 py-2 text-white bg-blue-700 hover:bg-blue-800 border-l border-gray-300 rounded-r-lg focus:ring-4 focus:outline-none focus:ring-blue-300"
    >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
    </button>
</div>
{{-------------------------------CAR END----------------------------}}

{{-------------------------------Matricule START----------------------------}}
<div class="relative max-w-sm">
    <div
        x-data="{
            open: false,
            search: @js($mat),
            allMat: @js($allmat),
            filteredMatricules: [],
            selectedClient: @entangle('client_id'),
            selectedCar: @entangle('car_id'),
            selectedMatricule: @entangle('mat_id'),
            matField: @entangle('mat'),
            init() {
                this.updateFilteredMatricules();
                
                // Watch for matricule changes (including auto-selection from Livewire)
                this.$watch('selectedMatricule', (value) => {
                    if (value) {
                        const mat = this.allMat.find(m => m.id == value);
                        if (mat) {
                            this.search = mat.mat;
                        }
                    } else {
                        this.search = '';
                    }
                });
                
                // Watch for mat field changes from Livewire
                this.$watch('matField', (value) => {
                    if (value !== this.search) {
                        this.search = value;
                    }
                });
            },
            updateFilteredMatricules() {
                if (!this.selectedClient || !this.selectedCar) {
                    this.filteredMatricules = [];
                    return;
                }
                
                this.filteredMatricules = this.allMat.filter(mat => 
                    mat.client_id == this.selectedClient && mat.car_id == this.selectedCar
                );
            }
        }"
        @client-changed.window="
            // Reset matricule selection when client changes
            selectedMatricule = null;
            search = '';
            open = false;
            updateFilteredMatricules();
        "
        @car-changed.window="
            // Reset matricule selection when car changes
            selectedMatricule = null;
            search = '';
            open = false;
            updateFilteredMatricules();
        "
        @click.away="open = false"
        class="relative"
    >
        <label for="NewMat" class="block text-sm font-medium text-gray-700">Matricule</label>
        <input
            id="NewMat"
            type="text"
            class="block w-full p-2 text-gray-800 placeholder-gray-400 bg-white border border-gray-300 rounded-l-lg focus:ring-blue-500 focus:outline-none "
            x-model="search"
            @focus="open = true"
            @click="open = true"
            @input.debounce.100ms="
                open = true;
                $wire.set('mat', search);
            "
            :disabled="!selectedClient || !selectedCar"
            placeholder="Select client and car first"
            autocomplete="off"
        />
        
        <div class="absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded-lg dark:bg-neutral-800 dark:border-neutral-700 smooth-scroll"
             x-show="open && selectedClient && selectedCar && filteredMatricules.length > 0">
            <div class="overflow-hidden overflow-y-auto max-h-72">
                <template x-for="matricule in filteredMatricules.filter(m => search === '' || m.mat.toLowerCase().includes(search.toLowerCase()))" :key="matricule.id">
                <div
    class="flex items-center px-4 py-2 text-sm text-gray-800 cursor-pointer hover:bg-blue-600 hover:text-white"
    @mousedown.prevent="
        // use mousedown so it fires *before* the input blurs
        selectedMatricule = matricule.id;
        search = matricule.mat;
        open = false;
    "
  >
                        <span x-text="matricule.mat"></span>
                    </div>
                </template>
            </div>
        </div>
        
        
        <!-- Show message when no matricules available -->
        <div x-show="open && selectedClient && selectedCar && filteredMatricules.length === 0" 
             class="absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded-lg">
            <div class="px-4 py-2 text-sm text-gray-500">
                No matricules found for this client and car combination
            </div>
        </div>
        
        @error('mat_id')
            <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
        @enderror
    </div>
</div>
{{-------------------------------Matricule END----------------------------}}

@endif




                    <!-- Vehicle Details (Livewire Step 2) -->
                    @if($currentstep === 2)
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">KM</label>
                            <input
                                type="number"
                                wire:model="km"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            >
                            @error('km')
                                <span class="text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Remark</label>
                            <input
                                type="text"
                                wire:model="remark"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            >
                        </div>
                    </div>
                    @endif

                    <!-- Order Items (Livewire Step 3) -->
                    @if($currentstep === 3)
<!-- Payment Modal -->
<div
    x-show="paymentModalOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-90"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-90"
    class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-gray-800 bg-opacity-60"
    x-cloak
>
    <div class="relative w-full max-w-md px-4 py-8 mx-auto bg-white rounded-lg shadow-lg">
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900">
                Process Payment
            </h3>
            <button
                @click="paymentModalOpen = false"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
            >
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="space-y-6">
            <!-- Current Facture Info -->
            <div class="p-4 mb-4 rounded-lg bg-blue-50">
                <p class="mb-1 text-sm text-gray-700">
                    <span class="font-medium">Facture Total:</span> 
                    <span x-text="calculateTotal().toFixed(2) + ' DA'"></span>
                </p>
                
                @if(isset($facture) && $facture->exists)
                    <!-- This is an UPDATE scenario -->
                    <p class="text-sm text-orange-700">
                        <span class="font-medium">Current Paid Amount:</span>
                        <span class="font-semibold">{{ number_format($facture->paid_value ?? 0, 2) }} DA</span>
                    </p>
                    <p class="text-sm text-red-700">
                        <span class="font-medium">Current Remaining:</span>
                        <span class="font-semibold">{{ number_format(max(0, ($facture->total_amount ?? 0) - ($facture->paid_value ?? 0)), 2) }} DA</span>
                    </p>
                @else
                    <!-- This is a CREATE scenario -->
                    @if(isset($clientSold) && $clientSold !== null && $clientSold > 0)
                        <p class="text-sm text-green-700">
                            <span class="font-medium">Client Previous Sold:</span>
                            <span class="font-semibold">{{ number_format($clientSold, 2) }} DA</span>
                        </p>
                    @endif
                @endif
            </div>

            <!-- Total Amount Due -->
            <div class="flex items-center justify-between p-4 mb-4 rounded-lg bg-blue-50">
                <span class="text-sm font-medium text-gray-900">Total Amount Due</span>
                <span class="text-lg font-semibold text-gray-900">
                    @if(isset($facture) && $facture->exists)
                        <!-- UPDATE: Only show this facture's total -->
                        <span x-text="calculateTotal().toFixed(2) + ' DA'"></span>
                    @else
                        <!-- CREATE: Show facture total + previous sold -->
                        @if(isset($clientSold) && $clientSold !== null && $clientSold > 0)
                            <span x-text="(calculateTotal() + {{ $clientSold }}).toFixed(2) + ' DA'"></span>
                        @else
                            <span x-text="calculateTotal().toFixed(2) + ' DA'"></span>
                        @endif
                    @endif
                </span>
            </div>

            <!-- Payment Input -->
            <div class="mb-4">
                <label for="clientPaid" class="block mb-2 text-sm font-medium text-gray-900">
                    Payment Amount (DA)
                </label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    @if(isset($facture) && $facture->exists)
                        :max="calculateTotal()"
                        x-init="$watch('paymentModalOpen', value => { if(value) clientPaid = {{ $facture->paid_value ?? 0 }} })"
                    @else
                        :max="calculateTotal() + @js((float)($clientSold ?? 0))"
                        x-init="$watch('paymentModalOpen', value => { if(value) clientPaid = calculateTotal() + @js((float)($clientSold ?? 0)) })"
                    @endif
                    x-model.number="clientPaid"
                    id="clientPaid"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                />
            </div>

            <!-- New Remaining Amount -->
            <div class="flex items-center justify-between p-4 mt-2 rounded-lg bg-yellow-50">
                <span class="text-sm font-medium text-yellow-700">Remaining After Payment:</span>
                <span class="text-lg font-semibold text-yellow-700">
                    @if(isset($facture) && $facture->exists)
                        <!-- UPDATE: Only calculate for this facture -->
                        <span x-text="Math.max(0, calculateTotal() - (clientPaid || 0)).toFixed(2) + ' DA'"></span>
                    @else
                        <!-- CREATE: Calculate with previous sold -->
                        @if(isset($clientSold) && $clientSold !== null && $clientSold > 0)
                            <span x-text="Math.max(0, (calculateTotal() + {{ $clientSold }}) - (clientPaid || 0)).toFixed(2) + ' DA'"></span>
                        @else
                            <span x-text="Math.max(0, calculateTotal() - (clientPaid || 0)).toFixed(2) + ' DA'"></span>
                        @endif
                    @endif
                </span>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button
                    @click="paymentModalOpen = false"
                    class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-100"
                >
                    Cancel
                </button>
                <button
                    @click="paymentModalOpen = false; $wire.set('clientPaid', clientPaid); prepareSubmission();"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300"
                >
                    Confirm Payment
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Payment Modal -->
                    <div>
                        <!-- Entire Component Content Goes Here -->
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">Current Order</h2>
                            <button
                            class="px-4 py-2 font-semibold text-red-500 transition-transform duration-100 ease-in-out bg-red-200 rounded-md hover:bg-red-600 hover:text-white active:scale-90 "
                            @click="clearOrder">
                                Clear All
                            </button>
                        </div>
                        <div>
                            <!-- Order Items -->
                            <div class="space-y-4 max-h-[40vh] overflow-y-scroll smooth-scroll">
                                <template x-for="(item, index) in orderItems" :key="index">
                                    <div
                                        x-data="{ isDragging: false }"
                                        :data-drag-index="index"
                                        @mousedown.prevent="
                                            initDrag(index, $event);
                                            isDragging = true;
                                        "
                                        @mousemove.prevent="
                                            handleDragMove($event);
                                            if (isDragging) $event.preventDefault();
                                        "
                                        @mouseup.prevent="
                                            handleDragEnd($event);
                                            isDragging = false;
                                        "
                                        @mouseleave.prevent="
                                            handleDragEnd($event);
                                            isDragging = false;
                                        "
                                        class="relative flex items-center justify-between p-3 transition-all duration-200 ease-in-out rounded-lg bg-blue-50"
                                        :class="{
                                            'shadow-lg': Math.abs(dragState.dragOffset) > 50,
                                            'bg-red-100': Math.abs(dragState.dragOffset) > 100
                                        }"
                                    >
                                        <div class="flex-grow">
                                            <div class="font-semibold text-gray-800 capitalize" x-text="item.name"></div>
                                            <div class="text-sm font-bold text-red-500" x-text="item.description"></div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button
                                                class="flex items-center justify-center w-8 h-8 transition-transform duration-100 ease-in-out bg-gray-200 rounded-full active:scale-90"
                                                @click="updateQuantity(index, -1)"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="black" class="size-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                                </svg>
                                            </button>
                                            <span class="px-2 font-semibold" x-text="item.quantity"></span>
                                            <button
                                                class="flex items-center justify-center w-8 h-8 transition-transform duration-100 ease-in-out bg-gray-200 rounded-full active:scale-90"
                                                @click="updateQuantity(index, 1)"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="black" class="size-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="ml-4 font-bold text-blue-600" x-text="`${(item.price * item.quantity).toFixed(2)}`"></div>
                                    </div>
                                </template>
                            </div>

                            <!-- Modal Overlay -->
<!-- Modal Overlay -->
<div

    x-show="editModalOpen"

    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-90"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-90"
    {{-- class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" --}}

    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    x-cloak

>
    <!-- Modal Container -->
    <div
            class="relative p-6 bg-white rounded-lg shadow-xl w-96"
            x-show="editModalOpen"
    >
        <!-- Close Button -->
        <button
            @click="closeEditModal()"
            class="absolute text-gray-600 top-4 right-4 hover:text-red-700"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        <h2 class="mb-4 text-2xl font-bold">Edit Item</h2>

        <!-- Item Name -->
        <div class="mb-4">
            <label class="block mb-2 text-sm font-bold text-gray-700" for="item-name">
                Name
            </label>
            <input
                id="item-name"
                x-model="editedItem.name"
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-outline"
                type="text"
                {{-- wire:model.lazy="product" --}}
                @input="$wire.set('product', editedItem.name)"

            >
        </div>

        <!-- Item Description -->
        <div class="mb-4">
            <label class="block mb-2 text-sm font-bold text-gray-700" for="item-description">
                Description
            </label>
            <input
                id="item-description"
                x-model="editedItem.description"
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-outline"
                type="text"
            >
        </div>

        <!-- Item Quantity -->
        <div class="mb-4">
            <label class="block mb-2 text-sm font-bold text-gray-700">
                Quantity
            </label>
            <div class="flex items-center justify-center space-x-2 ">
                <button
                    @click="editedItem.quantity > 1 ? editedItem.quantity-- : null"
                    class="flex items-center justify-center w-10 h-10 transition-transform duration-100 transform bg-gray-200 rounded-full active:scale-90"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="black" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                    </svg>
                </button>
                <span class="px-2 text-lg font-semibold" x-text="editedItem.quantity"></span>
                <button
                    @click="editedItem.quantity++"
                    class="flex items-center justify-center w-10 h-10 transition-transform duration-100 transform bg-gray-200 rounded-full active:scale-90"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="black" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Item Price -->
        <div class="mb-4">
            <label class="block mb-2 text-sm font-bold text-gray-700" for="item-price">
                Price
            </label>
            <input
                id="item-price"
                x-model.number="editedItem.price"
                type="number"
                step="0.01"
                min="0"
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-outline"
            >
        </div>

        <!-- Modal Actions -->
        <div class="flex justify-between mt-6">
            <button
                @click="updateItem()"
                class="px-4 py-2 font-bold text-white transition-transform duration-100 transform bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline active:scale-90"
            >
                Update
            </button>
        </div>
    </div>
</div>

<!-- Minimal Tailwind CSS Custom Animations -->
<style>
@keyframes fade-in {
    from { opacity: ; }
    to { opacity: 1; }
}

/* .animate-fade-in {
    animation: fade-in 0.3s ease-out;
} */
</style>

                            <!-- Extra Charge Buttons -->
                            <div class="mt-8 space-y-4">
                                <div class="flex justify-center space-x-3">
                                    <button
                                    class="px-4 py-2 font-semibold text-white transition-transform duration-100 ease-in-out bg-green-500 rounded-md hover:bg-green-600 active:scale-90"
                                    @click="addExtraCharge(2000)">
                                    +2000 DA
                                    </button>
                                    <button
                                    class="px-4 py-2 font-semibold text-white transition-transform duration-100 ease-in-out bg-green-500 rounded-md hover:bg-green-600 active:scale-90"
                                    @click="addExtraCharge(1000)">
                                    +1000 DA
                                    </button>
                                    <button
                                    class="px-4 py-2 font-semibold text-white transition-transform duration-100 ease-in-out bg-green-500 rounded-md hover:bg-green-600 active:scale-90"
                                    @click="addExtraCharge(500)">
                                    +500 DA
                                    </button>

                                </div>
                                <div class="flex justify-center space-x-3">
                                    <button
                                    class="px-4 py-2 font-semibold text-white transition-transform duration-100 ease-in-out bg-red-500 rounded-md hover:bg-red-600 active:scale-90"
                                    @click="discount(2000)"
                                    :disabled="!canApplyDiscount(2000)"
                                    :class="{'opacity-50 cursor-not-allowed': !canApplyDiscount(2000)}">
                                    -2000 DA
                                </button>
                                <button
                                    class="px-4 py-2 font-semibold text-white transition-transform duration-100 ease-in-out bg-red-500 rounded-md hover:bg-red-600 active:scale-90"
                                    @click="discount(1000)"
                                    :disabled="!canApplyDiscount(1000)"
                                    :class="{'opacity-50 cursor-not-allowed': !canApplyDiscount(1000)}">
                                    -1000 DA
                                </button>
                                <button
                                    class="px-4 py-2 font-semibold text-white transition-transform duration-100 ease-in-out bg-red-500 rounded-md hover:bg-red-600 active:scale-90"
                                    @click="discount(500)"
                                    :disabled="!canApplyDiscount(500)"
                                    :class="{'opacity-50 cursor-not-allowed': !canApplyDiscount(500)}">
                                    -500 DA
                                </button>
                                </div>
                            </div>

                            <!-- Total and Validate -->
                            {{-- <template x-for="(item, index) in orderItems" :key="index">
                                <div>
                                    <span x-text="extraCharge"></span>
                                    <span x-text="discountAmount"></span>
                                    <span x-text="totalPrice"></span>
                                </div>
                            </template> --}}
                            <div class="p-4 mt-6 rounded-lg bg-blue-50">
                                <!-- Extra Charges -->
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-lg font-semibold text-green-600">Extra Charges:</span>
                                    <span
                                        class="text-xl font-bold text-green-700"
                                        {{-- x-text="extraCharge > 0 ? '+' + extraCharge.toFixed(2) + ' DA' : '0.00 DA'" --}}
                                        {{-- x-text="Number(extraCharge) > 0 ? '+' + Number(extraCharge).toFixed(2) + ' DA' : '0.00 DA'" --}}
                                        x-text="Number(extraCharge ?? 0) > 0 ? '+' + Number(extraCharge ?? 0).toFixed(2) + ' DA' : '0.00 DA'"
                                        >
                                    </span>
                                </div>

                                <!-- Discounts -->
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-lg font-semibold text-red-600">Discounts:</span>
                                    <span
                                        class="text-xl font-bold text-red-700"
                                        x-text="Number(discountAmount) > 0 ? '-' + Number(discountAmount).toFixed(2) + ' DA' : '0.00 DA'">

                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xl font-bold text-gray-800">Total:</span>
                                    <span
                                    class="text-2xl font-bold cursor-pointer"
                                    :class="customTotalEnabled ? 'text-red-600' : 'text-blue-600'"
                                    @click="openOverrideModal"
                                    x-text="calculateTotal().toFixed(2) + ' DA'">

                                    </span>
                                </div>
                                {{-- <button
                                    class="w-full py-3 mt-4 font-semibold text-white transition bg-blue-600 rounded-lg hover:bg-blue-700"
                                    @click="validateOrder">
                                    Validate Order
                                </button> --}}
                                <button
                                    class="w-full py-3 mt-4 font-semibold text-white transition bg-blue-600 rounded-lg hover:bg-blue-700"
                                type="button"
                                    @click="validateOrder">
                                    Validate Order
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Override Total Modal -->
                    <div
                    x-show="overrideTotalModalOpen"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-90"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                    x-cloak
                    >
                    <div class="relative p-6 bg-white rounded-lg shadow-xl w-96">
                        <button @click="overrideTotalModalOpen = false"
                            class="absolute text-gray-600 top-4 right-4 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <h2 class="mb-4 text-2xl font-bold">Override Total</h2>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700">New Total (DA)</label>
                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                x-model.number="overriddenTotal"
                                class="w-full px-3 py-2 border rounded focus:outline-none focus:shadow-outline"
                            />
                        </div>

                        <div class="flex justify-between mt-6">
                            <button
                                @click="applyOverriddenTotal"
                                class="px-4 py-2 font-bold text-white transition-transform duration-100 ease-in-out bg-blue-600 rounded hover:bg-blue-700 active:scale-90">
                                Update
                            </button>
                        </div>
                    </div>
                    </div>

                    @endif

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between mt-6">
                        @if($currentstep > 1)
                        <button
                        wire:click="decrementstep"
                        type="button"
                        class="px-4 py-2 text-white transition-transform duration-100 ease-in-out bg-gray-400 rounded-md hover:bg-gray-500 active:scale-90"
                                    
                        >
                        Back
                    </button>
                        @endif

                        @if($currentstep < $totalstep)
                        <button
    type="button"
    wire:click="incrementstep"
    :disabled="
      <!-- for step 1, disable until client selected -->
      ($wire.currentstep === 1 && !$wire.client_id) ||
      <!-- for step 2, disable until car & matricule selected -->
      ($wire.currentstep === 2 && (!$wire.car_id || !$wire.mat_id))
    "
    class="px-4 py-2 bg-blue-600 text-white rounded-md disabled:opacity-50 disabled:cursor-not-allowed"
>
    Next
</button>
                        @endif

                        @if($currentstep === $totalstep)
                        <div>


    <!-- Single Button to Submit and Auto-Reset -->
    {{-- <button @click="prepareSubmission" class="px-4 py-2 text-white bg-green-600 rounded-md hover:bg-green-700">
        <span x-text="isSubmitted ? 'Reset' : 'Submit Order'"></span>
    </button> --}}

                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
    <style>
.smooth-scroll {
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch; /* for momentum on mobile */
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 transparent;
}
.smooth-scroll::-webkit-scrollbar {
    width: 8px;
    background: transparent;
}
.smooth-scroll::-webkit-scrollbar-thumb {
    background: #cbd5e1; /* Tailwind slate-300 */
    border-radius: 8px;
}
.smooth-scroll::-webkit-scrollbar-thumb:hover {
    background: #94a3b8; /* Tailwind slate-400 */
}
.smooth-scroll::-webkit-scrollbar-track {
    background: transparent;
}
</style>
</div>

<script>
function orderApp(products) {
    return {
        products: products,
        orderItems: @json(is_array($orderItems) ? $orderItems : json_decode($orderItems ?? '[]')),
        extraCharge: @json($extraCharge ?? 0),
        discountAmount: @json($discountAmount ?? 0),
        searchTerm: '',
        dragState: {
            direction: null,
            startX: 0,
            isDragging: false,
            draggedIndex: null,
            dragOffset: 0
        },
        editModalOpen: false,
        editingItem: null,
        editedItem: null,
        overrideTotalModalOpen: false,
        overriddenTotal: null,
        customTotalEnabled: false,
        customTotalValue: null,
        isSubmitted: false,  // This flag ensures submission only once

openOverrideModal() {
    this.overriddenTotal = this.calculateTotal();
    this.overrideTotalModalOpen = true;
},



applyOverriddenTotal() {
    const baseTotal = this.totalPrice() + this.extraCharge; // Total without discount
    const difference = baseTotal - this.overriddenTotal; // Difference to apply

    if (difference >= 0) {
        // Treat as discount if the new total is lower
        this.discountAmount = difference;
        // Keep the extra charge as is, it doesn't get reset
    } else {
        // Treat as extra charge if the new total is higher
        this.extraCharge = Math.abs(difference); // Make the difference positive
        this.discountAmount = 0; // Reset discount when applying extra charge
    }

    this.overrideTotalModalOpen = false; // Close the modal
},

        get filteredProducts() {
            if (!this.searchTerm) return this.products;

            return this.products.filter(product =>
                product.name.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                product.description.toLowerCase().includes(this.searchTerm.toLowerCase())
            );
        },

        addToOrder(product) {
    // Get the product ID with more comprehensive checks
    const productId = product.id ?? product.product_id ?? product.item_id;
    
    // Also check for name matching as a fallback (useful for edit contexts)
    const existingItem = this.orderItems.find(item => {
        // First try ID matching
        const itemId = item.id ?? item.product_id ?? item.item_id;
        if (itemId && productId && itemId === productId) {
            return true;
        }
        
        // Fallback to name matching (case-insensitive)
        if (item.name && product.name) {
            return item.name.toLowerCase().trim() === product.name.toLowerCase().trim();
        }
        
        return false;
    });

    if (existingItem) {
        // Increment quantity if item already exists
        existingItem.quantity++;
    } else {
        // Add new item to order
        this.orderItems.push({
            ...product,
            id: productId, // Normalize ID
            quantity: 1
        });
    }
},

        updateQuantity(index, change) {
            if (this.orderItems[index].quantity + change <= 0) {
                this.orderItems.splice(index, 1);

                if (this.orderItems.length === 0) {
                    this.extraCharge = 0;
                    this.discountAmount = 0;
                }
            } else {
                this.orderItems[index].quantity += change;
            }
        },

        // Enhanced drag-related methods
        initDrag(index, event) {
            this.dragState = {
                direction: null,
                startX: event.clientX,
                isDragging: true,
                draggedIndex: index,
                dragOffset: 0
            };
        },

        handleDragMove(event) {
            if (!this.dragState.isDragging) return;

            // Calculate drag distance and direction
            const dragDistance = event.clientX - this.dragState.startX;
            this.dragState.dragOffset = dragDistance;
            this.dragState.direction = dragDistance > 0 ? 'right' : '';

            // Apply movement effect
            const draggedElement = document.querySelector(`[data-drag-index="${this.dragState.draggedIndex}"]`);
            if (draggedElement) {
                draggedElement.style.transform = `translateX(${dragDistance}px)`;

                // Add visual feedback for drag intensity
                if (Math.abs(dragDistance) > 50) {
                    draggedElement.classList.add('bg-red-100');
                } else {
                    draggedElement.classList.remove('bg-red-100');
                }
            }
        },
        prepareSubmission() {
            if (this.orderItems.length === 0) {
                alert('Please add items to the order');
                return;
            }

            // Only send all the data to Livewire when actually submitting
            @this.set('orderItems', JSON.stringify(this.orderItems));
            @this.set('total_amount', this.calculateTotal());
            @this.set('extraCharge', Number(this.extraCharge));
            @this.set('discountAmount', Number(this.discountAmount));

            // Call the update method
            @this.update();
        },

        calculateTotal() {
    const subtotal = this.totalPrice();
    return Math.max(0, subtotal + this.extraCharge - this.discountAmount); // Ensure no negative total
},
  // Drag methods remain the same as previous implementation...
  handleDragEnd(event) {
            if (!this.dragState.isDragging) return;

            const dragDistance = event.clientX - this.dragState.startX;
            const absDistance = Math.abs(dragDistance);

            // Open modal when drag exceeds 100px
            if (absDistance > 100) {
                if (this.dragState.direction === 'right') {
                    // Open edit modal
                    this.openEditModal(this.dragState.draggedIndex);
                } else if (this.dragState.direction === 'left') {
                    // Remove item
                    this.orderItems.splice(this.dragState.draggedIndex, 1);
                }
            }

            // Reset drag state and styles
            const draggedElement = document.querySelector(`[data-drag-index="${this.dragState.draggedIndex}"]`);
            if (draggedElement) {
                draggedElement.style.transform = '';
                draggedElement.classList.remove('bg-red-100');
            }

            // Reset drag state
            this.dragState = {
                direction: null,
                startX: 0,
                isDragging: false,
                draggedIndex: null,
                dragOffset: 0
            };
        },



        openEditModal(index) {
            this.$nextTick(() => {
                this.editingItem = this.orderItems[index];
                this.editedItem = { ...this.editingItem };
                this.editModalOpen = true;
            });
        },


        updateItem() {
            const index = this.orderItems.findIndex(item => item.id === this.editingItem.id);

            if (index !== -1) {
                this.orderItems[index] = { ...this.editedItem };
            }

            this.editModalOpen = false;
        },

        closeEditModal() {
            this.editModalOpen = false;

            this.$nextTick(() => {
                this.editingItem = null;
                this.editedItem = null;
            });
        },

        // Existing methods continue...
        clearOrder() {
            this.orderItems = [];
            this.extraCharge = 0;
            this.discountAmount = 0;
            this.searchTerm = "";
        },

        // Add these updated methods to your orderApp function

        addExtraCharge(amount) {
            // Only update the local Alpine.js state
            this.extraCharge = (Number(this.extraCharge) || 0) + Number(amount);
        },

        discount(amount) {
            const currentTotal = this.totalPrice() + (Number(this.extraCharge) || 0);
            const currentDiscount = Number(this.discountAmount) || 0;

            if (currentTotal >= (currentDiscount + amount)) {
                // Only update the local Alpine.js state
                this.discountAmount = currentDiscount + Number(amount);
            } else {
                alert('Discount cannot exceed total amount');
            }
        },

canApplyDiscount(amount) {
    if (this.orderItems.length === 0) return false;

    const currentTotal = this.totalPrice() + (Number(this.extraCharge) || 0);
    const currentDiscount = Number(this.discountAmount) || 0;

    return currentTotal >= (currentDiscount + amount);
},

totalPrice() {
    return this.orderItems.reduce((total, item) => {
        return total + (Number(item.price) * Number(item.quantity));
    }, 0);
},

    validateOrder() {
            // Always open payment modal regardless of client sold status or checkbox
            this.paymentModalOpen = true;
            return;
        }
    }
}
    // --- Payment Modal Extension ---
    (function() {
        const originalOrderApp = window.orderApp;
        window.orderApp = function(...args) {
            const base = originalOrderApp(...args);
            return Object.assign(base, {
                paymentModalOpen: false,
                paymentAmount: 0,
                clientPaid: 0,
                willMakePayment: false,
                remainingAmount: 0,
                calculateRemaining() {
                    this.remainingAmount = Math.max(0, this.calculateTotal() - this.clientPaid);
                }
            });
        };
    })();
    document.addEventListener('DOMContentLoaded', function() {
  // ——— Client input “clear” ———
  const clientInput = document.getElementById('NewClient');
  clientInput.addEventListener('input', function() {
    if (this.value === '') {
      // Clear Livewire’s client_id
      @this.set('client_id', null);
      // Tell the car & matricule selectors to reset
      window.dispatchEvent(new CustomEvent('client-changed', {
        detail: { clientId: null }
      }));
    }
  });

  // ——— Car input “clear” ———
  const carInput = document.getElementById('carSearchInput');
  carInput.addEventListener('input', function() {
    if (this.value === '') {
      @this.set('car_id', null);
      window.dispatchEvent(new CustomEvent('car-changed', {
        detail: { carId: null, clientId: @this.get('client_id') }
      }));
    }
  });

  // ——— Matricule input “clear” ———
  const matInput = document.getElementById('NewMat');
  matInput.addEventListener('input', function() {
    if (this.value === '') {
      @this.set('mat_id', null);
      window.dispatchEvent(new CustomEvent('car-changed', {
        // we reuse the car-changed event so your matricule block resets
        detail: { carId: @this.get('car_id'), clientId: @this.get('client_id') }
      }));
    }
  });
});
</script>

