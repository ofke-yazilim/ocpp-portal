// tailwind.config.js
export default {
    content: [
        './resources/**/*.blade.php',  // Blade şablonları
        './resources/**/*.js',         // JS dosyaları
        './resources/**/*.jsx',        // React JSX
        './resources/**/*.ts',         // TS dosyaları
        './resources/**/*.tsx',        // React TSX
    ],
    theme: {
        extend: {
            // Buraya özel renk, spacing vs ekleyebilirsin
            colors: {
                'custom-bg': '#101922',   // Örnek özel renk
                "primary": "#1173d4",
                "background-light": "#f6f7f8",
                "background-dark": "#101922",
            },
            fontFamily: {
                "display": ["Inter"]
            },
            borderRadius: {
                "DEFAULT": "0.25rem",
                "lg": "0.5rem",
                "xl": "0.75rem",
                "full": "9999px"
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/container-queries'),
    ],
};
