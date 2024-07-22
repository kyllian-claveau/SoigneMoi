/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      colors: {
        primary: "#E01D5B",
        secondary: "#481C4B",
      },
    },
  },
  plugins: [],
}

