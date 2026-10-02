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
            fontFamily: {
                sans: ['Montserrat', 'Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                primary: '#2C666E',
                background: '#F0EDEE',
                brand: {
                    DEFAULT: '#198754',
                    dark: '#146c43',
                    darker: '#11653e',
                    light: '#e9f7ef',
                    lighter: '#f5f8f6',
                },
            },
        },
    },

    plugins: [forms],
};
