import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/file.css',
                'resources/css/md.css',
                'resources/css/book.css',
            ],
            refresh: true,
        }),
    ],
});
