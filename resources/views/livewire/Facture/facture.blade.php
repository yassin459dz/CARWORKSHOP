<div
    x-data="orderApp({{ $product->toJson() }})"
    x-init="initializeState()"
    class="mx-auto max-w-7xl"
>
    <form wire:submit.prevent="submit">
        <div class="bg-white shadow-2xl rounded-xl">
            <div class="flex flex-col md:flex-row">
                <!-- Left Section: Product List (mostly unchanged) -->
                <div class="relative w-full p-6 md:w-3/5 bg-gray-50">
                    <!-- THIS HOW TO CALL THE SEARCH AND CREATE A NEW PRODUCT -->

            <!-- Right: Search bar and button -->
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
                    <div class="grid max-h-screen grid-cols-1 gap-4 p-3 overflow-y-auto sm:grid-cols-2 lg:grid-cols-3 no-scrollbar">
                        <template x-for="product in filteredProducts" :key="product.id">
                            <div
                                @click="$wire.currentstep === 3 ? addToOrder(product) : null"
                                class="flex flex-col p-6 transition-transform bg-white border border-gray-100 shadow-md dark:bg-gray-900 rounded-2xl dark:border-gray-800 group"
                                :class="$wire.currentstep === 3 ? 'cursor-pointer hover:shadow-xl hover:-translate-y-1' : 'cursor-not-allowed bg-gray-100 opacity-70'"
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
<div>
    <div class="relative max-w-sm ">
        <label for="client" class="block text-sm font-medium text-gray-700">Client Name</label>
        <div class="flex items-center space-x-0">
            <div x-data="{ search: '', open: false }" class="relative w-full">
                <!-- Searchable Input -->
                <input
                id="NewClient"

                    type="text"
                    x-model="search"
                    class="block w-full p-2 text-gray-800 placeholder-gray-400 bg-white border-gray-300 rounded-l-lg focus:ring-blue-500 focus:outline-none"
                    placeholder="Client"
                    @focus="open = true"

                />


                <!-- Dropdown -->
                <div class="absolute z-50 w-full mt-1.5 bg-white border border-gray-200 rounded-lg shadow-lg"
                     x-show="open && search.length > 0">
                    <div class="overflow-hidden overflow-y-auto max-h-72">
                        <template x-for="client in [...document.querySelectorAll('#clientSelect option')].filter(c => c.innerText.toLowerCase().includes(search.toLowerCase()))">
                            <div
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-800 cursor-pointer hover:bg-blue-600 hover:text-white"
                                @click="
                                    search = client.innerText;
                                    document.querySelector('#clientSelect').value = client.value;
                                    open = false;
                                    $wire.set('selectedClient', client.value); // Explicit Livewire update
                                "
                            >
                                <span x-text="client.innerText"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Select Dropdown (Hidden) -->
                <select id="clientSelect" wire:model.lazy="selectedClient" class="hidden">
                    <option value="">Select Client</option>
                    @foreach ($allclients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
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
        @error('selectedClient')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
        <!-- Car Dropdown (Dependent on Client) -->
        <label for="carSelect" class="block mt-4 text-sm font-medium text-gray-700">Car</label>
        <div class="flex items-center space-x-0">
            <select id="carSelect" wire:model.live="selectedCar" wire:key="carSelect" class="block w-full p-2 text-gray-800 bg-white border border-gray-300 rounded-l-lg focus:ring-blue-500 focus:outline-none">
                <option wire:key="car-select-default" value="">Select Car</option>
                @foreach ($groupedCars as $groupLabel => $cars)
                    @php $groupClasses = $groupLabel == 'Owned Car' ? 'text-green-600' : 'text-red-600'; @endphp
                    <optgroup wire:key="group-{{ $groupLabel }}" label="{{ $groupLabel }}" class="font-semibold {{ $groupClasses }}">
                        @foreach ($cars as $car)
                            <option wire:key="car-option-{{ $car->id }}" class="font-semibold" value="{{ $car->id }}">{{ $car->model }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>

            <button
                type="button"
                @click="console.log('Car button clicked')"
                class="px-2.5 py-2 text-white bg-blue-700 hover:bg-blue-800 border-l border-gray-300 rounded-r-lg focus:ring-4 focus:outline-none focus:ring-blue-300"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </button>
        </div>
    <!-- Validation Error Message -->
    @error('selectedCar')
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
        <!-- Matricule Dropdown (Dependent on Car) -->
        <div x-data="{
            showNewMat: false,
            mat: @entangle('mat'),
            selectedMat: @entangle('selectedMat'),
            selectedCar: @entangle('selectedCar'),
            selectedClient: @entangle('selectedClient'),
            init() {
                this.$watch('selectedCar', (val) => {
                    console.log('Car re-selected after matricule creation:', val);
                });
            }
        }"
         class="relative">
            <div class="relative max-w-sm">
                <label for="matSelect" class="block text-sm font-medium text-gray-700">Matricule</label>
                <div class="flex items-center space-x-0">
                    <select
                        id="matSelect"
                        wire:model.live="selectedMat"
                        @change="console.log('Matricule selected:', $event.target.value)"
                        class="block w-full p-2 border-gray-200 rounded-l-lg"
                    >
                        <option value="">Select Matricule</option>
                        @foreach ($this->filteredMatricules as $mat)
                            <option value="{{ $mat->id }}">{{ $mat->mat }}</option>
                        @endforeach
                    </select>

                    <!-- Create New Matricule Button -->
                    <button
                        type="button"
                        class="px-2.5 py-2 text-white bg-blue-700 hover:bg-blue-800 border-l border-gray-300 rounded-r-lg focus:ring-4 focus:outline-none focus:ring-blue-300"
                        @click="showNewMat = !showNewMat; console.log('Toggle new matricule input:', showNewMat)"
                        :disabled="!selectedClient || !selectedCar"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
    <!-- Validation Error Message -->
    @error('selectedMat')
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
 <!-- New Matricule Input Section -->
 <div
 class="relative max-w-sm mt-2"
 x-show="showNewMat"
 x-transition:enter="transition ease-out duration-300"
 x-transition:enter-start="opacity-0 transform scale-95"
 x-transition:enter-end="opacity-100 transform scale-100"
 x-transition:leave="transition ease-in duration-200"
 x-transition:leave-start="opacity-100 transform scale-100"
 x-transition:leave-end="opacity-0 transform scale-95"
>
 <div class="relative max-w-sm">
     <label for="NewMat" class="block text-sm font-medium text-gray-700">New Matricule</label>
     <div class="relative flex items-center">
         <div class="relative flex w-full">
             <input
                 id="NewMat"
                 type="text"
                 class="block w-full p-2 text-sm text-gray-800 placeholder-gray-400 bg-white border border-gray-200 rounded-l-lg focus:border-blue-500 focus:ring-blue-500"
                 x-model="mat"
                 placeholder="Enter new matricule"
                 @input="console.log('New matricule input:', $event.target.value)"
             />
             <button
                 type="button"
                 class="px-2.5 py-2 text-white bg-blue-700 hover:bg-blue-800 border-l border-gray-300 rounded-r-lg focus:ring-4 focus:outline-none focus:ring-blue-300"
                 @click="
                     if (mat && mat.length > 0) {
                         // Store the selected car temporarily
                         const currentCar = selectedCar;

                         $wire.createMatricule(mat).then(() => {
                             // Clear mat input and close the input field
                             mat = '';
                             showNewMat = false;

                             // Explicitly reset the selected car
                             $wire.set('selectedCar', currentCar);
                             setTimeout(() => {
                                 // Dispatch custom event for car restoration after short delay
                                 window.dispatchEvent(new CustomEvent('car-restored', {
                                     detail: { id: currentCar }
                                 }));
                             }, 50);
                         });
                     }
                 "
             >
                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 20 20">
                     <path fill="currentColor" d="M3 5a2 2 0 0 1 2-2h1v3.5A1.5 1.5 0 0 0 7.5 8h4A1.5 1.5 0 0 0 13 6.5V3h.379a2 2 0 0 1 1.414.586l1.621 1.621A2 2 0 0 1 17 6.621V15a2 2 0 0 1-2 2v-5.5a1.5 1.5 0 0 0-1.5-1.5h-7A1.5 1.5 0 0 0 5 11.5V17a2 2 0 0 1-2-2zm9-2H7v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5zm2 8.5V17H6v-5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5" />
                 </svg>
             </button>
         </div>
     </div>
 </div>
</div>
</div>



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
                    <div>
                        <!-- Entire Component Content Goes Here -->
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">Current Order</h2>
                            <button
                            class="px-4 py-2 font-semibold text-red-500 transition-transform duration-100 ease-in-out bg-red-200 rounded-md hover:bg-red-600 hover:text-white active:scale-90"
                            @click="clearOrder">
                                Clear All
                            </button>
                        </div>
                        <div>
                            <!-- Order Items -->
                            <div class="space-y-4 max-h-[40vh] overflow-y-scroll no-scrollbar">
                                <template x-for="(item, index) in orderItems" :key="item.id">
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
                                                class="flex items-center justify-center w-8 h-8 transition-transform duration-100 ease-in-out bg-gray-200 rounded-full active:scale-90 "
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

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>

                            <!-- Extra Charge Buttons -->
                            <div class="mt-8 space-y-4">
                                <div class="flex justify-center space-x-3">
                                    <button
                                    class="px-4 py-2 font-semibold text-white transition-transform duration-100 ease-in-out bg-green-500 rounded-md active:scale-90 hover:bg-green-600 "
                                    @click="addExtraCharge(2000)">
                                    +2000 DA
                                    </button>
                                    <button
                                    class="px-4 py-2 font-semibold text-white transition-transform duration-100 ease-in-out bg-green-500 rounded-md active:scale-90 hover:bg-green-600"
                                    @click="addExtraCharge(1000)">
                                    +1000 DA
                                    </button>
                                    <button
                                    class="px-4 py-2 font-semibold text-white transition-transform duration-100 ease-in-out bg-green-500 rounded-md active:scale-90 hover:bg-green-600"
                                    @click="addExtraCharge(500)">
                                    +500 DA
                                    </button>

                                </div>
                                <div class="flex justify-center space-x-3">
                                    <button
                                    class="px-4 py-2 font-semibold text-white transition-transform duration-100 ease-in-out bg-red-500 rounded-md active:scale-90 hover:bg-red-600"
                                    @click="discount(2000)"
                                    :disabled="!canApplyDiscount(2000)"
                                    :class="{'opacity-50 cursor-not-allowed': !canApplyDiscount(2000)}">
                                    -2000 DA
                                </button>
                                <button
                                    class="px-4 py-2 font-semibold text-white transition-transform duration-100 ease-in-out bg-red-500 rounded-md active:scale-90 hover:bg-red-600"
                                    @click="discount(1000)"
                                    :disabled="!canApplyDiscount(1000)"
                                    :class="{'opacity-50 cursor-not-allowed': !canApplyDiscount(1000)}">
                                    -1000 DA
                                </button>
                                <button
                                    class="px-4 py-2 font-semibold text-white transition-transform duration-100 ease-in-out bg-red-500 rounded-md active:scale-90 hover:bg-red-600"
                                    @click="discount(500)"
                                    :disabled="!canApplyDiscount(500)"
                                    :class="{'opacity-50 cursor-not-allowed': !canApplyDiscount(500)}">
                                    -500 DA
                                </button>
                                </div>
                            </div>

                            <!-- Total and Validate -->
                            <div class="p-4 mt-6 rounded-lg bg-blue-50">
                                <!-- Extra Charges -->
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-lg font-semibold text-green-600">Extra Charges:</span>
                                    <span
                                        class="text-xl font-bold text-green-700"
                                        x-text="extraCharge > 0 ? '+' + extraCharge.toFixed(2) + ' DA' : '0.00 DA'">
                                    </span>
                                </div>

                                <!-- Discounts -->
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-lg font-semibold text-red-600">Discounts:</span>
                                    <span
                                        class="text-xl font-bold text-red-700"
                                        {{-- x-text="discount > 0 ? '-' + discount.toFixed(2) + ' DA' : '0.00 DA'"> --}}
                                        x-text="discountAmount > 0 ? '-' + discountAmount.toFixed(2) + ' DA' : '0.00 DA'">

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
                                <button @click="prepareSubmission" class="w-full py-3 mt-4 font-semibold text-white transition-transform duration-100 ease-in-out bg-blue-600 rounded-lg active:scale-90 hover:bg-blue-700">
                                    <span x-text="isSubmitted ? 'Reset' : 'Validate Order'"></span>
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
                                wire:click="incrementstep"
                                type="button"
                                class="px-4 py-2 font-medium text-white transition-transform duration-100 ease-in-out bg-blue-700 rounded-lg hover:bg-blue-800 active:scale-90 "
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
            class="px-4 py-2 font-bold text-white bg-blue-600 rounded hover:bg-blue-700">
            Update
        </button>
    </div>
</div>
</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function orderApp(products) {
    return {
        products: products,
        orderItems: [],
        extraCharge: 0,
        discountAmount: 0,
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
        isSubmitted: false,  // This flag ensures submission only once
        overrideTotalModalOpen: false,
overriddenTotal: null,
customTotalEnabled: false,
customTotalValue: null,
        // Function to open the override modal
openOverrideModal() {
    this.overriddenTotal = this.calculateTotal(); // Set current total as the overridden total
    this.overrideTotalModalOpen = true; // Open the modal
},

// Function to apply the overridden total
applyOverriddenTotal() {
    const baseTotal = this.totalPrice() + this.extraCharge; // Calculate the total without any discounts
    const difference = baseTotal - this.overriddenTotal; // Find the difference between the new and current total

    if (difference >= 0) {
        // If the new total is lower, treat it as a discount
        this.discountAmount = difference;
        // The extra charge stays as is, so no change
    } else {
        // If the new total is higher, treat it as an extra charge
        this.extraCharge = Math.abs(difference); // Set the absolute value of the difference as the extra charge
        this.discountAmount = 0; // Reset discount when applying an extra charge
    }

    this.overrideTotalModalOpen = false; // Close the modal after applying the override
},
        // initializeState() {
        //     // Ensure everything is reset on page load
        //     this.editModalOpen = false;
        //     this.editedItem = {
        //         name: '',
        //         description: '',
        //         quantity: 1,
        //         price: 0
        //     };
        // },
        // Existing methods...
        get filteredProducts() {
            if (!this.searchTerm) return this.products;

            return this.products.filter(product =>
                product.name.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                product.description.toLowerCase().includes(this.searchTerm.toLowerCase())
            );
        },

        addToOrder(product) {
            const existingItem = this.orderItems.find(item => item.id === product.id);
            if (existingItem) {
                existingItem.quantity++;
            } else {
                this.orderItems.push({
                    ...product,
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
            @this.submit();
                        // Automatically reset after a short delay
                        setTimeout(() => {
                @this.set('orderItems', null);
                @this.set('total_amount', 0);
                @this.set('extraCharge', 0);
                @this.set('discountAmount', 0);
            }, 100);
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

        addExtraCharge(amount) {
            this.extraCharge += amount;
        },

        discount(amount) {
            const currentTotal = this.totalPrice() + this.extraCharge;

            if (currentTotal >= amount) {
                this.discountAmount += amount;
            } else {
                alert('Discount amount exceeds current total.');
            }
        },

        canApplyDiscount(amount) {
            if (this.orderItems.length === 0) {
                return false;
            }

            const currentTotal = this.totalPrice() + this.extraCharge;

            return currentTotal >= amount &&
                   (currentTotal - this.discountAmount - amount) >= 0;
        },

        calculateTotal() {
    const subtotal = this.totalPrice(); // Get the subtotal
    return Math.max(0, subtotal + this.extraCharge - this.discountAmount); // Ensure the total is never negative
},

        totalPrice() {
            return this.orderItems.reduce((total, item) => total + item.price * item.quantity, 0);
        },

        validateOrder() {
            alert('Order validated! Total: ' + this.calculateTotal().toFixed(2) + ' DA');
        }
    }
}
</script>
