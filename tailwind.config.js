/** @type {import('tailwindcss').Config} */
export default {
    content: [
      './resources/views/**/*.blade.php', // Adjust these paths to match where your Blade files are located
      './resources/js/**/*.vue', // If you use Vue.js components
      './resources/js/**/*.jsx', // If you use React components
      './vendor/filament/**/*.php', // Ensure Filament's files are included
      // Add other paths as necessary
    ],
    theme: {
      extend: {
        colors: {
          blue: {
            DEFAULT: '#1e40af', // Your custom blue color
            // You can add more shades if needed
          },
        },
      },
    },
    plugins: [],
  }
