<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-6xl sm:px-6 lg:px-8">
        <div class="flex h-16">
            @if(session('cashbox_unlocked'))
                <form method="POST" action="{{ route('lock-cashbox') }}" style="display:inline;">
                    @csrf
                    <button
                        type="submit"
                        class="absolute top-0 right-0 px-6 py-2 mt-2 mr-4 font-medium text-white transition-transform duration-100 ease-in-out bg-blue-600 rounded-lg shadow-md text-gl hover:bg-blue-700 active:scale-90"
                    >
                        Lock Cashbox
                    </button>
                </form>
            @endif
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <x-application-logo class="block w-auto text-gray-800 fill-current h-9" />
                    </a>

                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    {{-- <x-nav-link :href="route('brand')" :active="request()->routeIs('brand')" wire:navigate>
                        {{ __('Brands') }}
                    </x-nav-link> --}}
                    <x-nav-link :href="route('car')" :active="request()->routeIs('car')" wire:navigate>
                        {{ __('Cars') }}
                    </x-nav-link>
                    <x-nav-link :href="route('client')" :active="request()->routeIs('client')" wire:navigate>
                        {{ __('Client') }}
                    </x-nav-link>
                    <x-nav-link :href="route('matricule')" :active="request()->routeIs('matricule')" wire:navigate>
                        {{ __('Cars & Clients') }}
                    </x-nav-link>
                    <x-nav-link :href="route('facture')" :active="request()->routeIs('facture')" wire:navigate>
                        {{ __('Facture') }}
                    </x-nav-link>
                    <x-nav-link :href="route('Bl')" :active="request()->routeIs('Bl')" wire:navigate>
                        {{ __('Bl') }}
                    </x-nav-link>
                    <x-nav-link :href="route('ListFacture')" :active="request()->routeIs('allfacture')" wire:navigate>
                        {{ __('ALL Facture') }}
                    </x-nav-link>
                    <x-nav-link :href="route('product')" :active="request()->routeIs('product')" wire:navigate>
                        {{ __('ALL PRODUCT') }}
                    </x-nav-link>
                    <x-nav-link :href="route('deponse')" :active="request()->routeIs('deponse')" wire:navigate>
                        {{ __('DEPONSE') }}
                    </x-nav-link>
                    <x-nav-link :href="route('cashbox')" :active="request()->routeIs('cashbox')" wire:navigate>
                        {{ __('CASH BOX') }}
                    </x-nav-link>











    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="text-base font-medium text-gray-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>

<script>
    const toggle = document.getElementById('darkModeToggle');
    const moonIcon = document.getElementById('moonIcon');
    const sunIcon = document.getElementById('sunIcon');
    const modeText = document.getElementById('modeText');

    // Set initial state based on system preference or localStorage
    let isDark = localStorage.theme === 'dark' ||
        (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);

    // Initial setup
    updateUI();

    toggle.addEventListener('click', () => {
        isDark = !isDark;
        updateUI();
        updateStorage();
    });

    function updateUI() {
        // Update icons
        moonIcon.classList.toggle('hidden', isDark);
        sunIcon.classList.toggle('hidden', !isDark);

        // Update text
        modeText.textContent = !isDark ? 'Light Mode' : 'Dark Mode';

        // Update button colors
        toggle.classList.toggle('bg-gradient-to-r', true);
        if (isDark) {
            toggle.classList.remove('from-yellow-400', 'via-orange-500', 'to-red-500');
            toggle.classList.add('from-indigo-500', 'via-purple-500', 'to-pink-500');
        } else {

            toggle.classList.remove('from-indigo-500', 'via-purple-500', 'to-pink-500');
            toggle.classList.add('from-yellow-400', 'via-orange-500', 'to-red-500');
        }

        // Update document
        document.documentElement.classList.toggle('dark', isDark);
    }

    function updateStorage() {
        localStorage.theme = isDark ? 'dark' : 'light';
    }
    </script>
