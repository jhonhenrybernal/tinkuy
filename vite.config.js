import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/views/themes/xylo/sass/app.scss',
                'resources/views/themes/xylo/js/app.js',
                'resources/views/themes/xylo/css/animate.min.css',
                'resources/views/themes/xylo/css/slick.css',
                'resources/views/themes/xylo/css/style.css',
                'resources/views/themes/xylo/css/custom.css',
                'resources/views/themes/xylo/js/main.js',
                'resources/views/themes/xylo/js/slick.min.js',
            ],
            refresh: true,
        }),
    ],
});
