import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/**/*.js',
    ],
    mode: 'jit',


    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: '#fdfdf7',
                    light: '#fefefb',
                    dark: '#e0e0c8',
                },
                secondary: {
                    DEFAULT: '#536b7b',
                    light: '#6b8493',
                    dark: '#3c4c57',
                },
            },
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui'],
            },
        },
    },

    plugins: [forms],
};
