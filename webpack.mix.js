const mix = require('laravel-mix');
const path = require("path");
const NodePolyfillPlugin = require("node-polyfill-webpack-plugin")
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
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    .version();
mix.copyDirectory('vendor/tinymce/tinymce', 'public/js/tinymce');
mix.alias({
    AutoNumeric$: path.join(__dirname, 'node_modules/autonumeric/dist/autoNumeric.min')
});
mix.webpackConfig({
    stats: {
        children: true,
    },
});
module.exports = {
    plugins: [
        new NodePolyfillPlugin()
    ]
}
