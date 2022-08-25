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

mix.js('resources/js/app.js', 'public/js').sass('resources/sass/app.scss', 'public/css');

if (process.env.APP_ENV === 'production') {
    mix.minify('resources/js/grids.js', 'public/js/grids.js');
    mix.version();
    mix.sourceMaps();
} else {//local development
    mix.browserSync(process.env.APP_URL);
    mix.scripts('resources/js/grids.js', 'public/js/grids.js');
}

