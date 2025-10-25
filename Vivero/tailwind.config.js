import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./resources/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
        "./node_modules/flowbite/**/*.js",
    ],

    safelist: [
        'bg-[var(--navbar-color)]', // 👈 Necesario para clases dinámicas
    ],

    theme: {
        extend: {
            keyframes: {
                float: {
                    "0%, 100%": { transform: "translateY(0)" },
                    "50%": { transform: "translateY(-3px)" },
                },
            },
            animation: {
                float: "float 3s ease-in-out infinite",
            },
            fontFamily: {
                roboto_sans: ["Roboto", ...defaultTheme.fontFamily.sans],
                roboto_condensed: ["Roboto Condensed", ...defaultTheme.fontFamily.sans],
                roboto: ['Roboto', 'sans-serif'],
                inter: ['Inter', 'sans-serif'],
                poppins: ['Poppins', 'sans-serif'],
            },
            fill: (theme) => ({
                ...theme("colors"),
            }),
            backgroundImage: {
                leafs: "url('/public/storage/images/pattern1.png')",
            },
            colors: {
                greenPrimary: "#40C239",
                greenDark: "#70A37F",
                greenMid: "#79B473",
                blueLight: "#D4DCFF",
                blueDark: "#48639C",

                efore: "#F8F6F4",
                eprimary: "#3E0345",
                esecondary: "#8090BF",
                eaccent: "#F6E867",
                eaccent2: "#AEC68D",

                "efore-100": "#F9F7F5",
                "efore-200": "#F0E9E3",
                "efore-300": "#E8D9C7",
                "efore-400": "#D0B39C",
                "efore-500": "#B88D71",
                "efore-600": "#9F6B47",
                "efore-700": "#7F492B",
                "efore-800": "#633419",
                "efore-900": "#4A260E",

                "eprimary-100": "#6A145F",
                "eprimary-200": "#5B0D59",
                "eprimary-300": "#4D064F",
                "eprimary-400": "#40013F",
                "eprimary-500": "#3E0345",
                "eprimary-600": "#32022F",
                "eprimary-700": "#26021A",
                "eprimary-800": "#1A0110",
                "eprimary-900": "#0F0008",

                "esecondary-100": "#AAB8D9",
                "esecondary-200": "#92A1C7",
                "esecondary-300": "#7A8AAD",
                "esecondary-400": "#617396",
                "esecondary-500": "#8090BF",
                "esecondary-600": "#63749B",
                "esecondary-700": "#4C5C7F",
                "esecondary-800": "#384761",
                "esecondary-900": "#262F41",

                "eaccent-100": "#F8F9A6",
                "eaccent-200": "#F8F87E",
                "eaccent-300": "#F8F656",
                "eaccent-400": "#F8F52E",
                "eaccent-500": "#F6E867",
                "eaccent-600": "#E7D23D",
                "eaccent-700": "#CBBB28",
                "eaccent-800": "#A6941A",
                "eaccent-900": "#83710F",

                "eaccent2-100": "#B2D7A7",
                "eaccent2-200": "#A3C98F",
                "eaccent2-300": "#94BA77",
                "eaccent2-400": "#85AB5F",
                "eaccent2-500": "#AEC68D",
                "eaccent2-600": "#8E9E74",
                "eaccent2-700": "#70825C",
                "eaccent2-800": "#586945",
                "eaccent2-900": "#415130",
            },
        },
    },

    plugins: [forms, require("flowbite/plugin")],
};
