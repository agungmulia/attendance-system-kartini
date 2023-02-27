/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
    variants: {
        extend: {
            translate: ["group-hover", "hover"],
            scale: ["group-hover"],
            borderRadius: ["group-hover"],
        },
    },
    theme: {
        extend: {
            spacing: {
                78: "312px",
            },
            keyframes: {
                "fade-in-down": {
                    from: {
                        transform: "translateY(-0.75rem)",
                        opacity: "0",
                    },
                    to: {
                        transform: "translateY(0rem)",
                        opacity: "1",
                    },
                },
                "fade-in-left": {
                    from: {
                        transform: "translateX(0.75rem)",
                        opacity: "0",
                    },
                    to: {
                        transform: "translateX(0rem)",
                        opacity: "1",
                    },
                },
                "fade-in-right": {
                    from: {
                        transform: "translateX(-0.75rem)",
                        opacity: "0",
                    },
                    to: {
                        transform: "translateX(0rem)",
                        opacity: "1",
                    },
                },
            },
            animation: {
                "fade-in-down": "fade-in-down 0.2s ease-in-out both",
                "fade-in-left": "fade-in-left 0.2s ease-in-out both",
                "fade-in-right": "fade-in-right 0.2s ease-in-out both",
            },
        },
    },
    plugins: [require("@tailwindcss/forms")],
};
