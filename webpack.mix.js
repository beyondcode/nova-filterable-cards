let mix = require('laravel-mix')

mix.js('resources/js/card.js', 'dist/js')
   .sass('resources/sass/card.scss', 'dist/css')
    .webpackConfig({
        resolve: {
            symlinks: false,
            alias: {
                '@': path.resolve(__dirname, 'vendor/laravel/nova/resources/js/'),
            },
        },
    })
