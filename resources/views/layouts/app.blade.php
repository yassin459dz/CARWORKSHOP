<!DOCTYPE html>
<html
      {{-- x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      x-init="$watch('darkMode', value => localStorage.setItem('darkMode', value))"
      :class="{ 'dark': darkMode }" --}}
      >
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap4.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>


  </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
        <script>
  Livewire.on('cashboxUnlocked', () => {
    const form = document.getElementById('lockCashboxForm');
    if (form) form.style.display = '';
  });
          </script>

    </body>
</html>
