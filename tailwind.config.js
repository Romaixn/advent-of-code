/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./assets/**/*.js", "./templates/**/*.html.twig"],
  theme: {
    extend: {
      colors: {
        primary: "#99ff99",
        secondary: "#0f0f23",
      },
    },
  },
  plugins: [],
};
