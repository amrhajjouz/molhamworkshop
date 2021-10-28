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

 mix.sass("resources/scss/libs.scss", "public/css")
 .sass("resources/scss/theme.scss", "public/css")
 .sass("resources/scss/theme-dark.scss", "public/css")
 .sass("resources/scss/theme-pink.scss", "public/css")
 .sass("resources/scss/theme-rtl.scss", "public/css")
 .sass("resources/scss/theme-rtl-dark.scss", "public/css")
 .sass("resources/scss/theme-rtl-pink.scss", "public/css").sourceMaps();
 
 mix.js("resources/js/theme.js", "public/js").sourceMaps();
 
 mix.copy("resources/img", "public/img");
 
 mix.copy("resources/fonts", "public/fonts");