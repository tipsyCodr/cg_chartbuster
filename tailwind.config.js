/** @type {import('tailwindcss').Config} */
const defaultTheme = require("tailwindcss/defaultTheme");
export default {
    darkMode: "class", //false, class, media
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/**/*.blade.php",
        "./resources/**/**/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        screens: {
            xs: "350px",
            ...defaultTheme.screens,
        },
        extend: {
            colors: {
                accent: "#ff6600",
                "accent-dark": "#ff6600",
                "accent-light": "#ffaa0017",
            },
            fontFamily: {
                montserrat: ["Montserrat", "sans-serif"],
                poppins: ["Poppins", "sans-serif"],
            },
            fontSize: {
                xxs: ".65rem",
            },
            backgroundImage: {
                "gradient-bottom": "linear-gradient(180deg, transparent 5%,#00000080 , #000000 90%)",
                "gradient-dark": "linear-gradient(0deg, #434313FF 10px, #000000, #000000 200px)",
            },
            textShadow: {
                'default': '0 2px 4px rgba(0, 0, 0, 0.5)',
                'lg': '0 4px 6px rgba(0, 0, 0, 0.7)',
                'xl': '0 6px 8px rgba(0, 0, 0, 0.8)',
            }
        },
    },
    plugins: [
        function({ addUtilities }) {
            const newUtilities = {
                '.scrollbar-hide::-webkit-scrollbar': {
                    display: 'none'
                },
                '.scrollbar-hide': {
                    '-ms-overflow-style': 'none',
                    'scrollbar-width': 'none'
                },
                '.text-shadow': {
                    'text-shadow': '0 2px 4px rgba(0, 0, 0, 0.5)'
                },
                '.text-shadow-md': {
                    'text-shadow': '0 4px 6px rgba(0, 0, 0, 0.7)'
                },
                '.text-shadow-lg': {
                    'text-shadow': '0 6px 8px rgba(0, 0, 0, 0.8)'
                }
            }
            addUtilities(newUtilities)
        }
    ]
};
