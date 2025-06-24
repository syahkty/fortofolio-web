import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            // MENAMBAHKAN KONFIGURASI DARI DESAIN PORTOFOLIO
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                'poppins': ['Poppins', 'sans-serif'], // Font Poppins
            },
            colors: {
                'neon-cyan': '#00ffff',
                'dark-bg': '#0a0a0a',
                'glass-bg': 'rgba(17, 25, 40, 0.5)',
            },
            boxShadow: {
                'neon': '0 0 5px theme("colors.neon-cyan"), 0 0 20px theme("colors.neon-cyan / 50%")',
                'neon-sm': '0 0 2px theme("colors.neon-cyan"), 0 0 8px theme("colors.neon-cyan / 50%")',
            },
            backdropBlur: {
                'xl': '20px',
            },
            // Efek animasi untuk blob gradient
            animation: {
                'blob': 'blob 7s infinite',
            },
            keyframes: {
                blob: {
                    '0%': { transform: 'translate(0px, 0px) scale(1)' },
                    '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                    '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                    '100%': { transform: 'translate(0px, 0px) scale(1)' },
                },
            },
        },
    },

    plugins: [forms,typography],
};