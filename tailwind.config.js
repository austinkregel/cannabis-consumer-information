const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            keyframes: {
                wave: {
                  '0%': { transform: 'rotate(0.0deg)' },
                  '10%': { transform: 'rotate(14deg)' },
                  '20%': { transform: 'rotate(-8deg)' },
                  '30%': { transform: 'rotate(14deg)' },
                  '40%': { transform: 'rotate(-4deg)' },
                  '50%': { transform: 'rotate(10.0deg)' },
                  '60%': { transform: 'rotate(0.0deg)' },
                  '100%': { transform: 'rotate(0.0deg)' },
                },
              },
              animation: {
                'wave': 'wave 1s linear infinite',
              },

        },
    },

    plugins: [
        require('@tailwindcss/forms'),
    ],
};
