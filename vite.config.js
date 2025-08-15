import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    build: {
        cssMinify: 'lightningcss'
    },
    plugins: [
        laravel({
            input: [
                'resources/css/filament/theme.css',
                'resources/css/tenantforge.css',
                'resources/js/tenantforge.js',
            ],
            publicDirectory: process.env.PUBLIC_DIR || 'vendor/orchestra/testbench-core/laravel/public/vendor/tenantforge/core',
            buildDirectory: process.env.BUILD_DIR || 'build',
        }),
        tailwindcss()
    ],
})
