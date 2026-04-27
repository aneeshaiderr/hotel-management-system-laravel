/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/views/**/*.blade.php',  // Laravel blade files
        './resources/js/**/*.js',             // JS files
        './resources/css/**/*.css',           // Optional: agar CSS me classes hain
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'), // optional forms plugin
    ],
};
