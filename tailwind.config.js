module.exports = {
  content: ["./source/**/*.{html,js}", "./source/index.php"],
  theme: {
    extend: {},
  },
  plugins: [require("tailwind-scrollbar-hide")],
};
