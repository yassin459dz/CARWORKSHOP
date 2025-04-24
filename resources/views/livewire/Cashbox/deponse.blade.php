<div>
    <!-- Type Selection -->
    <label class="block mb-2 text-sm font-medium text-gray-900">Type</label>
    <ul class="grid w-full gap-6 mb-4 md:grid-cols-2">
        <li>
            <input type="radio" id="entree" name="type" value="ENTRÉE" wire:model="type" class="hidden peer" required />
            <label for="entree"
                class="items-center w-full p-5 text-blue-600 transition-transform duration-100 ease-in-out bg-blue-100 rounded-md cursor-pointer peer-checked:text-white peer-checked:bg-blue-600 hover:bg-blue-600 hover:text-white active:scale-95">
                <div class="block">
                    <div class="w-full text-xl font-semibold">ENTRÉE</div>
                </div>
            </label>
        </li>
        <li>
            <input type="radio" id="sortie" name="type" value="SORTIE" wire:model="type" class="hidden peer" />
            <label for="sortie"
                class="items-center w-full p-5 text-red-600 transition-transform duration-100 ease-in-out bg-red-100 rounded-md cursor-pointer peer-checked:text-white peer-checked:bg-red-600 hover:bg-red-600 hover:text-white active:scale-95">
                <div class="block">
                    <div class="w-full text-xl font-semibold">SORTIE</div>
                </div>
            </label>
        </li>
    </ul>

    <!-- Montant -->
    <label for="montant" class="block mb-2 text-sm font-medium text-gray-900">Montant</label>
    <input wire:model="montant" type="number" name="montant"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
        required />
    @error('montant')
    <div class="relative px-4 py-2 mt-2 text-sm text-red-700 bg-red-100 border border-red-400 rounded">
        {{ $message }}
    </div>
    @enderror

    <!-- Description -->
    <label for="desc" class="block mt-4 mb-2 text-sm font-medium text-gray-900">Description</label>
    <input wire:model="desc" type="text" name="description"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
        required />
    @error('description')
        <span class="text-sm text-danger"> {{$message}} </span>
    @enderror

    <!-- Save Button -->
    <button wire:click="save" type="button"
        class="w-full mt-6 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
        Save
    </button>
</div>

<script>
    document.addEventListener('livewire:initialized', function() {
        Livewire.on('showAlert', (data) => {
            alert(data.message);
        });
    });
</script>
