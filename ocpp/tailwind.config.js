// tailwind.config.js
export default {
    content: [
        './resources/**/*.blade.php',  // Blade şablonları
        './resources/**/*.js',         // JS dosyaları
        './resources/**/*.jsx',        // React JSX
        './resources/**/*.ts',         // TS dosyaları
        './resources/**/*.tsx',        // React TSX

        // Eklenen kaynaklar:
        '../views/**/*.blade.php',
        '../../vendor/laravel/framework/src/Illuminate/Pagination/resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            // Özel renkler
            colors: {
                'custom-bg': '#101922',
                'primary': '#1173d4',
                'background-light': '#f6f7f8',
                'background-dark': '#101922',

                'theme-green': {
                    50:  '#e6f4ea',
                    100: '#ccead5',
                    200: '#a3d9b8',
                    300: '#7ac99b',
                    400: '#52b87e',
                    500: '#2d6a4f',
                    600: '#24543f',
                    700: '#1b3e2f',
                    800: '#12291f',
                    900: '#09130f',
                },
            },
            // Yazı tipi
            fontFamily: {
                'display': ['Inter'],
            },
            // Kenar yuvarlatma
            borderRadius: {
                DEFAULT: '0.25rem',
                lg: '0.5rem',
                xl: '0.75rem',
                full: '9999px',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/container-queries'),
        require('tailwindcss-animate'), // Eklenen plugin
    ],
};
