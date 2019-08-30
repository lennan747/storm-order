const mix = require('laravel-mix');
const path = require('path');
const webpack = require('webpack');

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

mix.webpackConfig({
    output: {
        publicPath: ''
    },
    plugins: [
        // 不打包 moment.js 的语言文件以减小体积
        new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/),
    ],
    module: {
        rules: [
            {
                test: /\.(woff2?|ttf|eot|svg|otf)$/,
                loader: 'file-loader',
                options: {
                    publicPath: '/public/webfonts' + Config.resourceRoot
                }
            }
        ]
    }
});

mix.setResourceRoot('/public');

mix.setPublicPath(path.normalize('public'))
    .options({
        processCssUrls: false
    })
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .version()
    .copyDirectory('resources/assets/images', 'public/images')
    .copyDirectory('resources/assets/css', 'public/css')
    .copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts');
