import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // Tambahkan atau pastikan bagian build ini mengarah ke 'dist'
    build: {
        outDir: 'dist', // Ini adalah default Vite, pastikan tidak diubah
        emptyOutDir: true, // Opsional: Bersihkan direktori sebelum build
    }
});
