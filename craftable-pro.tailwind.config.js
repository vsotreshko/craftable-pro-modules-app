const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/views/craftable-pro.blade.php",
    "./resources/js/craftable-pro/**/*.vue",
    "./vendor/brackets/craftable-pro/resources/js/**/*.vue"
  ],

  theme: {
    extend: {
      colors: {
        primary: colors.indigo,
        secondary: colors.fuchsia,
        gray: colors.slate,
        warning: colors.amber,
        danger: colors.red,
        success: colors.green,
        info: colors.sky,
      },
      fontFamily: {
        sans: ["Nunito", ...defaultTheme.fontFamily.sans],
      },
      screens: {
        '3xl': '1800px',
      },
    },
  },

  plugins: [require("@tailwindcss/typography"), require("@tailwindcss/forms")],
};
