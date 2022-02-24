const mix = require('laravel-mix');
const local = require('./web/app/themes/commerce//assets/js/utils/local-config');
require('laravel-mix-versionhash');
require('laravel-mix-tailwind');

mix.setPublicPath('./web/app/themes/commerce/build');

mix.webpackConfig({
    externals: {
        "jquery": "jQuery",
    }
});

if (local.proxy) {
    
}

mix.browserSync({
    proxy: 'https://commerce.dev',
    open: false,
    files: [
        'web/app/themes/commerce/build/**/*.{css,js}',
        'web/app/themes/commerce/templates/**/*.php',
        'web/app/themes/commerce/**/*.php'
    ]
});

mix.tailwind();
mix.js('web/app/themes/commerce/assets/js/app.js', 'js');
mix.sass('web/app/themes/commerce/assets/scss/app.scss', 'css');

if (mix.inProduction()) {
    mix.versionHash();
    mix.sourceMaps();
}
