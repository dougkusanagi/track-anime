import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
const plugin = require("tailwindcss/plugin");

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    daisyui: {
        themes: ["night"],
    },

    plugins: [
        forms,
        require("flowbite/plugin"),
        plugin(({ matchUtilities, theme }) => {
            matchUtilities(
                {
                    glass: (value, { modifier }) => {
                        const offset = modifier || value;
                        const height = `calc(100% - ${offset})`;

                        return {
                            "&::before": {
                                content: "var(--tw-content)",
                                position: "absolute",
                                inset: "0",
                                bottom: `-${offset}`,
                                maskImage: `linear-gradient(to bottom, black 0, black ${height}, transparent ${height})`,
                                "--tw-backdrop-blur": `blur(${value})`,
                                backdropFilter:
                                    "var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate)",
                            },
                        };
                    },
                },
                {
                    values: theme("blur"),
                    modifiers: theme("spacing"),
                }
            );

            matchUtilities(
                {
                    "glass-edge": (value, { modifier }) => {
                        const offset = modifier || value;
                        const top = `calc(100% - ${offset} - 1px)`;
                        const bottom = `calc(100% - ${offset})`;

                        return {
                            "&::before": {
                                content: "var(--tw-content)",
                                position: "absolute",
                                inset: "0",
                                bottom: `-${offset}`,
                                maskImage: `linear-gradient(to bottom, transparent 0, transparent ${top}, black ${top}, black ${bottom}, transparent ${bottom})`,
                                "--tw-backdrop-blur": `blur(${value})`,
                                "--tw-backdrop-brightness": `brightness(1.5)`,
                                "--tw-backdrop-saturate": `saturate(1.5)`,
                                backdropFilter:
                                    "var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate)",
                            },
                        };
                    },
                },
                {
                    values: theme("blur"),
                    modifiers: theme("spacing"),
                }
            );
        }),
    ],
};
