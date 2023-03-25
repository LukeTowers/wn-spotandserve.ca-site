module.exports = {
    content: [
        // Blocks provided by plugins
        '../../plugins/*/*/blocks/*.block',

        './theme.yaml',
        './**/*.htm',
        './assets/src/js/**/*.{js,vue}'
    ],
    theme: {
        extend: {
            colors: {
                primary: 'var(--primary)',
                secondary: 'var(--secondary)',
            },
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
        require('@tailwindcss/forms'),
    ],
}
