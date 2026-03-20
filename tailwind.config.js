import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                cesi: {
                    green: {
                        50: '#effdf7',
                        100: '#d4f8e6',
                        200: '#acefcf',
                        300: '#78e0b2',
                        400: '#41d290',
                        500: '#08c271',
                        600: '#05a764',
                        700: '#048654',
                    },
                    yellow: {
                        50: '#fffdf1',
                        100: '#fff7cc',
                        200: '#ffef99',
                        300: '#ffe36b',
                        400: '#ffd84d',
                        500: '#f1c232',
                    },
                },
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
