import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                // This ensures "Figtree" is used without breaking the fallback fonts
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // Do NOT put colors here unless you want to overwrite Tailwind's defaults.
            // Keeping this empty allows bg-indigo-600 to work naturally.
        },
    },

    plugins: [forms],
};