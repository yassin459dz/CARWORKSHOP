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
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
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
                    <x-nav-link :href="route('caisse')" :active="request()->routeIs('caisse')" wire:navigate>
                        {{ __('CASH BOX') }}
                    </x-nav-link>

    {{-- the tuggle dark mode  --}}
    <button
    id="darkModeToggle"
    class="fixed flex items-center gap-2 p-2 text-white transition-all duration-500 ease-in-out rounded-lg shadow-md right-52 top-4 group hover:scale-110 hover:shadow-lg hover:shadow-orange-500/50"
    >
    <svg id="sunIcon" class="w-5 h-5 -mt-1 group-hover:animate-bounce-slow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
    </svg>
    <svg id="moonIcon" class="hidden w-5 h-5 group-hover:animate-spin-slow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="5"/>
        <line x1="12" y1="1" x2="12" y2="3"/>
        <line x1="12" y1="21" x2="12" y2="23"/>
        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
        <line x1="1" y1="12" x2="3" y2="12"/>
        <line x1="21" y1="12" x2="23" y2="12"/>
        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
    </svg>
    <span id="modeText" class="text-sm font-medium">Dark Mode</span>
    </button>
    {{-- the tuggle dark mode  --}}
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">




            </div>

            <!-- Hamburger -->
            <div class="flex items-center -me-2 sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

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
