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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.sass', 'public/css', {
        implementation: require('sass')
    });

mix.webpackConfig({
    resolve: {
        alias: {
            ziggy: path.resolve('vendor/tightenco/ziggy/dist/js/route.js'),
            // Puedes agregar más alias aquí si es necesario
        }
    },
    module: {
        rules: [
            // Añade aquí cualquier otra regla que necesites
            {
                test: /\.mjs$/,
                include: /node_modules/,
                type: "javascript/auto"
            }
        ]
    },
    // Puedes agregar más configuraciones de Webpack aquí si es necesario
});