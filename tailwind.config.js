/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      color: {
        primary: "#D53469",
        secondary: "#DAAD51",
      },
    },
  },
  plugins: [],
}

