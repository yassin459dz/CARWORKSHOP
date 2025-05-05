<div class="max-w-md p-6 mx-auto mt-8 bg-white shadow-lg rounded-2xl">
    <h2 class="mb-4 text-2xl font-semibold text-gray-800">CASH OUT</h2>

    {{-- Montant --}}
    <div class="mb-4">
        <label for="montant" class="block mb-1 text-sm font-medium text-gray-700">Montant </label>
        <input wire:model.debounce="montant" id="montant" type="number" min="0" step="0.01"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Entrez le montant">
        @error('montant')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Description --}}
    <div class="mb-6">
        <label for="desc" class="block mb-1 text-sm font-medium text-gray-700">Description</label>
        <textarea wire:model.debounce="desc" id="desc" rows="3"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Ajoutez une description (facultatif)"></textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Save Button --}}
    <button wire:click="save" wire:loading.attr="disabled"
        class="flex items-center justify-center w-full px-5 py-2 font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50">
        <span wire:loading.remove>Enregistrer</span>
    </button>

    {{-- Success Alert --}}
    <div x-data="{ open: false, message: '' }"
         x-show="open"
         x-transition
         x-init="Livewire.on('showAlert', data => { message = data.message; open = true; setTimeout(() => open = false, 3000) })"
         class="p-3 mt-4 text-sm text-green-800 bg-green-100 border border-green-200 rounded-lg">
        <span x-text="message"></span>
    </div>
</div>
