import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */

export default {

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        // './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.js",
        "./node_modules/flowbite/**/*.js",

    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                'spin-slow': 'spin 1.5s linear infinite',
                'bounce-slow': 'bounce 2s ',
            },
        },
    },
    plugins: [
        forms,
        require('flowbite/plugin'),
    ],
};
