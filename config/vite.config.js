import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
  // Base public path when served in production
  base: './',
  
  // Project root directory
  root: 'src',
  
  // Development server settings
  server: {
    port: 3000,
    open: true, // Auto-open browser
    cors: true, // Enable CORS
  },
  
  // Build configuration
  build: {
    // Output directory
    outDir: '../dist',
    
    // Empty the output directory before build
    emptyOutDir: true,
    
    // Generate source maps for production
    sourcemap: false,
    
    // Configure rollup options
    rollupOptions: {
      input: {
        main: resolve(__dirname, 'src/templates/index.html'),
        services: resolve(__dirname, 'src/templates/services.html'),
      },
    },
  },
  
  // Resolve aliases for cleaner imports
  resolve: {
    alias: {
      '@': resolve(__dirname, 'src'),
      '@css': resolve(__dirname, 'src/css'),
      '@js': resolve(__dirname, 'src/js'),
      '@components': resolve(__dirname, 'src/components'),
      '@assets': resolve(__dirname, 'src/assets'),
    },
  },
  
  // CSS processing options
  css: {
    // Generate source maps for css
    devSourcemap: true,
    
    // CSS modules options
    modules: {
      // Customize the CSS modules class naming pattern
      generateScopedName: '[name]__[local]___[hash:base64:5]',
    },
  },
}); 