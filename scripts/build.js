#!/usr/bin/env node

import { spawn } from 'child_process';
import { fileURLToPath } from 'url';
import { dirname, join } from 'path';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

// Parse command line arguments
const args = process.argv.slice(2);
let publicDirectory = null;
let buildDirectory = null;

// Parse arguments
for (let i = 0; i < args.length; i++) {
    if (args[i] === '--public-dir' && i + 1 < args.length) {
        publicDirectory = args[i + 1];
        i++; // Skip next argument as it's the value
    } else if (args[i] === '--build-dir' && i + 1 < args.length) {
        buildDirectory = args[i + 1];
        i++; // Skip next argument as it's the value
    }
}

// Set environment variables if provided
const env = { ...process.env };
if (publicDirectory) {
    env.PUBLIC_DIR = publicDirectory;
    console.log(`Setting PUBLIC_DIR to: ${publicDirectory}`);
}
if (buildDirectory) {
    env.BUILD_DIR = buildDirectory;
    console.log(`Setting BUILD_DIR to: ${buildDirectory}`);
}

// Run vite build with the environment variables
const viteProcess = spawn('npx', ['vite', 'build'], {
    cwd: join(__dirname, '..'),
    env,
    stdio: 'inherit'
});

viteProcess.on('close', (code) => {
    process.exit(code);
});

viteProcess.on('error', (error) => {
    console.error('Error running vite build:', error);
    process.exit(1);
});
