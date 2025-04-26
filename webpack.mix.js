const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/assets/js/app.min.js').sourceMaps();
mix.sass('resources/css/app.scss', 'public/assets/css/app.min.css').sourceMaps();
mix.copyDirectory('resources/img', 'public/assets/img');
mix.copyDirectory('node_modules/bootstrap/dist', 'public/assets/dist/bootstrap');
mix.copy('node_modules/jquery/dist/jquery.min.js', 'public/assets/dist/jquery/jquery.min.js');
mix.copy('node_modules/jquery/dist/jquery.min.map', 'public/assets/dist/jquery/jquery.min.map');
