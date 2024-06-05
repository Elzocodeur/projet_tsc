/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./template/**/*.html.php","main.html.php"],
  theme: {
    extend: {},
  },
  plugins: [
    require('daisyui'),
  ],
}
