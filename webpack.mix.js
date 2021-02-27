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

mix.js('resources/js/app.js', 'public/js/app.js')
    .scripts('resources/js/site.js', 'public/js/site.js')
    .scripts('resources/js/back.js', 'public/js/back.js');

mix.sass('resources/sass/app.scss', 'public/css')
    .styles('resources/css/site.css', 'public/css/site.css')
    .styles('resources/css/back.css', 'public/css/back.css');
