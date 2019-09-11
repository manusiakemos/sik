const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/backend/main.js', 'public/js')
// .js('resources/frontend/frontend.js', 'public/js')
// .sass('resources/frontend/scss/frontend.scss', 'public/css')
    .sass('resources/backend/scss/style.scss', 'public/css');

