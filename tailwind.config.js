/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                'primaer': '#004D9E',
                'sekundaer': '#0093f9',
            },
        },
    },
    plugins: [require("daisyui")],
}
