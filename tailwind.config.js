const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                dm: ['"DM Sans"'],
                fraun: ['Fraunces'],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};