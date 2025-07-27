import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // Hapus atau sesuaikan bagian build untuk gunakan default Laravel
    build: {
        outDir: 'public/build', // Sesuai default Laravel-Vite
        emptyOutDir: true,
        manifest: true, // Penting untuk auto-detection asset di Laravel
    }
});