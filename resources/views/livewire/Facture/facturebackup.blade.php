<div>
    {{-- <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Facture
        </h2>
    </x-slot> --}}
    {{-- <div class="px-4 sm:px-0">
        <h6 class="d-flex justify-content-center">  </h6>

        <h3 class="text-lg font-medium leading-6 text-gray-900">Step {{$currentstep}}</h3>
        <p class="mt-1 text-sm text-gray-600">out of {{$totalstep}}</p>
    </div> --}}
<div class="px-4">
<div class="" >
        <ol class="flex items-center p-3 mx-auto space-x-4 text-lg font-medium text-center text-gray-500 bg-white border border-gray-200 rounded-t-lg shadow-sm max-w-7xl dark:text-gray-400 sm:text-xl dark:bg-gray-800 dark:border-gray-700 sm:p-4 sm:space-x-6 rtl:space-x-reverse">
            <li class="flex items-center text-blue-600 dark:text-blue-500">
                <span class="flex items-center justify-center w-8 h-8 mr-3 border border-blue-600 rounded-full shrink-0 dark:border-blue-500">
                    1
                </span>
            Personal <span class="hidden sm:inline-flex sm:ms-2"></span>
            <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
            </svg>
        </li>
        <li class="flex items-center">
            <span class="flex items-center justify-center w-8 h-8 mr-3 border border-blue-600 rounded-full shrink-0 dark:border-blue-500">
                2
            </span>
            Account <span class="hidden sm:inline-flex sm:ms-2"></span>
            <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
            </svg>
        </li>
        <li class="flex items-center">
            <span class="flex items-center justify-center w-8 h-8 mr-3 border border-blue-600 rounded-full shrink-0 dark:border-blue-500">
                3
            </span>
            Review <span class="hidden sm:inline-flex sm:ms-2"></span>
        </li>
    </ol>
    <div class=" sm:mt-0">
        <div class="mx-auto md:grid max-w-7xl ">

            {{-- <div class="flex items-center justify-center md:col-span-2"> --}}


            {{-- </div> --}}

            {{-- <div class="md:col-span-2">
                 @if ($errors->isNotEmpty())
                    <div class="relative px-4 py-3 mb-4 text-sm text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                        <strong class="font-bold">Oops!</strong>
                        <span class="block sm:inline">There are some errors with your submission.</span>
                    </div>
                @endif
                @if ($success)
                    <div class="relative px-4 py-3 mb-4 text-sm text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
                        <span class="block sm:inline">{{ $success }}</span>
                        <span wire:click="resetSuccess" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="w-6 h-6 text-green-500 fill-current" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                        </span>
                    </div>
                @endif --}}
                <form wire:submit.prevent="submit">
                    <div class="overflow-hidden shadow sm:rounded-b-lg">
                        <div class="bg-white ">
                            {{-- <div class="px-4 py-5 bg-white sm:p-6"> --}}

                            @if($currentstep===1)
                            <div class="flex flex-col sm:p-6">

                                {{-- THE FACTURE N° --}}
                                {{-- <div class="w-full py-2">
                                    <label for="facture" class="block text-sm font-medium text-gray-700">Facture N°</label>
                                    <!-- Display facture number as an h3 tag -->
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                                        {{ str_pad($facture_number, 8, '0', STR_PAD_LEFT) }}
                                    </h3>
                                </div> --}}
                                {{-- <div class="w-full py-2">
                                    <label for="facture_number" class="block text-sm font-medium text-gray-700">Fac</label>
                                    <input wire:model.lazy="facture_number" type="number" name="facture_number" id="facture_number" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @error('fac') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                                </div> --}}
                                {{-- THE FACTURE N° --}}

                                {{-- THE SERCHABLE DROPDOWN --}}


                                    {{----------------------- THIS IF YOU WANT TO CLOSE DROPDOWN WITHOUTH BUTTON ----------------}}
                                    {{-- checkIfMatches() {
                                        // Check if any client matches the search term
                                        const hasMatch = this.allClients.some(client =>
                                            client.name.toLowerCase().includes(this.search.toLowerCase())
                                        );
                                        if (!hasMatch) {
                                            this.open = false; // Close the dropdown if no matches
                                        }
                                    } --}}
                                <div class="relative max-w-sm">
                                    <div
                                    x-data="{
                                        open: false,
                                        search: @js($search), // Initialize Alpine with Livewire's current search value
                                        allClients: @js($allclients), // Pass all clients from Livewire
                                        setClientName() {
                                            this.search = @this.allclients.find(c => c.id === @this.client_id)?.name || '';
                                        },

                                    }"
                                    x-init="setClientName()" {{-- Initialize search value when component loads --}}
                                    @click.away="open = false"

                                    class="relative">
                                    <div>
                                        <div>
                                            <button
                                            {{-- @click="$dispatch('lite-mode')" --}}
                                            @click="open = false;
                                            $dispatch('lite-mode')"

                                            data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                                Create Client
                                                {{-- <button @click="$dispatch('open-modal', search)" --}}

                                            </button>
                                        </div>
                                        <div wire:ignore>
                                            <livewire:create-edit-client />
                                        </div>
                                    </div>
                                    <!-- Input Field -->
                                    <label for="Client" class="block text-sm font-medium text-gray-700">Client Name</label>

                                    <input
                                    id="NewClient"
                                    type="text"
                                    class="block w-full p-2 text-sm text-gray-800 placeholder-gray-400 placeholder-gray-500 bg-white border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                    x-model="search"
                                    placeholder="Client"
                                    @focus="open = true"  {{-- Set open to true when focused --}}
                                    @input.debounce.100ms="
                                        open = true;
                                        $wire.set('search', search);
                                        checkIfMatches();
                                        // Check if the search term doesn't match any client, then update the modal's name field
                                        if (!allClients.some(client => client.name.toLowerCase().includes(search.toLowerCase()))) {
                                            $wire.set('name', search);
                                        }
                                    " {{-- Sync with Livewire and check for matches --}}
                                />
                                    <!-- Dropdown List -->
                                    <div class="absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded-lg dark:bg-neutral-800 dark:border-neutral-700"
                                         x-show="open && search.length > 0">
                                        <div class="overflow-hidden overflow-y-auto max-h-72">
                                            <template x-for="client in allClients" :key="client.id">
                                                <div
                                                class="flex items-center w-full px-4 py-2 text-sm text-gray-800 cursor-pointer hover:bg-blue-600 hover:text-white"
                                                @click="
                                                        $wire.set('client_id', client.id);
                                                        search = client.name;
                                                        open = false;
                                                    "
                                                    x-show="client.name.toLowerCase().includes(search.toLowerCase())">
                                                    <span x-text="client.name"></span>
                                                </div>
                                            </template>
                                        </div>
                                    </div>

                                    @error('client_id')
                                        <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

{{-------------------------------Matriquelle Start----------------------------}}
                                <div class="relative max-w-sm">
                                    <div
                                        x-data="{
                                            open: false,
                                            search: @js($mat), // Initialize search value
                                            allMat: @js($allmat), // All matricules passed from Livewire
                                            setMatName() {
                                                this.search = this.allMat.find(m => m.id === @js($mat_id))?.mat || '';
                                            },
                                        }"
                                        x-init="setMatName()" {{-- Initialize search value on load --}}
                                        @click.away="open = false"
                                        class="relative"
                                    >
                                        <!-- Create Matricule Button -->
                                        <div class="mb-2">
                                            <button
                                                @click="open = false; $dispatch('lite-mode')"
                                                data-modal-target="authentication-modal"
                                                data-modal-toggle="authentication-modal"
                                                class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                type="button"
                                            >
                                                Create Matricule
                                            </button>
                                            <div wire:ignore>
                                                {{-- <livewire:create-edit-matricule /> --}}
                                            </div>
                                        </div>

                                        <!-- Input Field -->
                                        <label for="NewMat" class="block text-sm font-medium text-gray-700">Matricule</label>
                                        <input
                                            id="NewMat"
                                            type="text"
                                            class="block w-full p-2 text-sm text-gray-800 placeholder-gray-400 placeholder-gray-500 bg-white border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                            x-model="search"
                                            @focus="open = true" {{-- Show dropdown on focus --}}
                                            @input.debounce.100ms="
                                                open = true;
                                                $wire.set('mat', search);
                                                // Check if the input matches any matricule, else update the modal's name field
                                                if (!allMat.some(m => m.mat.toLowerCase().includes(search.toLowerCase()))) {
                                                    $wire.set('mat', search);
                                                }
                                            "
                                        />

                                        <!-- Dropdown List -->
                                        <div
                                            class="absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded-lg dark:bg-neutral-800 dark:border-neutral-700"
                                            x-show="open && search.length > 0"
                                            x-transition
                                        >
                                            <div class="overflow-hidden overflow-y-auto max-h-72">
                                                <template x-for="matricule in allMat" :key="matricule.id">
                                                    <div
                                                    class="flex items-center w-full px-4 py-2 text-sm text-gray-800 cursor-pointer hover:bg-blue-600 hover:text-white"
                                                    @click="
                                                            $wire.set('mat_id', matricule.id);
                                                            search = matricule.mat;
                                                            open = false;
                                                        "
                                                        x-show="matricule.mat.toLowerCase().includes(search.toLowerCase())"
                                                    >
                                                        <span x-text="matricule.mat"></span>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>

                                        <!-- Error Message -->
                                        @error('mat_id')
                                        <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

{{-------------------------------Matriquelle END----------------------------}}


{{-------------------------------CAR START----------------------------}}

                                <div class="relative max-w-sm">
                                    <div
                                        x-data="{
                                            open: false,
                                            search: @js($search), // Initialize search value
                                            allCars: @js($allcars), // All cars passed from Livewire
                                            setCarName() {
                                                this.search = this.allCars.find(car => car.id === @js($car_id))?.model || '';
                                            },
                                        }"
                                        x-init="setCarName()" {{-- Initialize search value on load --}}
                                        @click.away="open = false"
                                        class="relative"
                                    >
                                        <!-- Create Car Button -->
                                        <div class="mb-2">
                                            <button
                                                @click="open = false; $dispatch('lite-mode')"
                                                data-modal-target="authentication-modal"
                                                data-modal-toggle="authentication-modal"
                                                class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                type="button"
                                            >
                                                Create Car
                                            </button>
                                            <div wire:ignore>
                                                <livewire:create-edit-client />
                                            </div>
                                        </div>

                                        <!-- Input Field -->
                                        <label for="NewCar" class="block text-sm font-medium text-gray-700">Car Model</label>
                                        <input
                                            id="NewCar"
                                            type="text"
                                            class="block w-full p-2 text-sm text-gray-800 placeholder-gray-400 placeholder-gray-500 bg-white border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                            x-model="search"
                                            @focus="open = true" {{-- Show dropdown on focus --}}
                                            @input.debounce.100ms="
                                                open = true;
                                                $wire.set('search', search);
                                                // Check if the input matches any car, else update the modal's name field
                                                if (!allCars.some(car => car.model.toLowerCase().includes(search.toLowerCase()))) {
                                                    $wire.set('model', search);
                                                }
                                            "
                                        />

                                        <!-- Dropdown List -->
                                        <div
                                            class="absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded-lg dark:bg-neutral-800 dark:border-neutral-700"
                                            x-show="open && search.length > 0"
                                            x-transition
                                        >
                                            <div class="overflow-hidden overflow-y-auto max-h-72">
                                                <template x-for="car in allCars" :key="car.id">
                                                    <div
                                                    class="flex items-center w-full px-4 py-2 text-sm text-gray-800 cursor-pointer hover:bg-blue-600 hover:text-white"
                                                    @click="
                                                            $wire.set('car_id', car.id);
                                                            search = car.model;
                                                            open = false;
                                                        "
                                                        x-show="car.model.toLowerCase().includes(search.toLowerCase())"
                                                    >
                                                        <span x-text="car.model"></span>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>

                                        <!-- Error Message -->
                                        @error('car_id')
                                        <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

{{-------------------------------CAR END----------------------------}}

                                </div>
                                @endif
                                @if($currentstep===2)

                                <div class="flex flex-col sm:p-6">

                                    <div class="w-full py-2">
                                        <label for="km" class="block text-sm font-medium text-gray-700">km</label>
                                        <input wire:model.lazy="km" type="number" name="km" id="km" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        @error('km') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="w-full py-2">
                                        <label for="remark" class="block text-sm font-medium text-gray-700">Remark</label>
                                        <input wire:model.lazy="remark" type="text" name="remark" id="remark" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>
                                </div>
                            @endif
                            @if($currentstep===3)

                            {{-- <div class="flex flex-col">
                                <div class="w-full py-2">
                                    <label for="product" class="block text-sm font-medium text-gray-700">product</label>
                                    <input wire:model.lazy="product" type="text" name="product" id="product" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @error('product') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div class="w-full py-2">
                                    <label for="qte" class="block text-sm font-medium text-gray-700">qte</label>
                                    <input wire:model.lazy="qte" type="number" name="qte" id="qte" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @error('qte') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div class="w-full py-2">
                                    <label for="price" class="block text-sm font-medium text-gray-700">price</label>
                                    <input wire:model.lazy="price" type="number" name="price" id="price" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @error('price') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div class="w-full py-2">
                                    <label for="total" class="block text-sm font-medium text-gray-700">total</label>
                                    <input wire:model.lazy="total" type="number" name="total" id="total" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @error('total') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div> --}}
                             <div wire:ignore>
                                <livewire:front />
                            </div>
                        @endif
                        </div>
                        <div class="flex items-center justify-between px-4 py-3 text-right bg-gray-50 sm:px-6">
                            @if($currentstep>1)
                                <button wire:click="decrementstep" type="button" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-gray-400 border border-transparent rounded-md shadow-sm hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                                    Back
                                </button>
                            @endif
                            @if($currentstep === $totalstep)
                            <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Submit
                                </button>
                            @endif
                            @if($currentstep<$totalstep)
                                <button wire:click="incrementstep" type="button" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Next
                                </button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>



