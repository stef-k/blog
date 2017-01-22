const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
  mix.sass('app.scss')
    .webpack(['public.js', 'app.js'], '', '', {watchOptions: {poll: true, aggregateTimeout: 500}});
  mix.scripts(['public.js', 'google-analytics.js'], 'public/js/public.js');
  mix.version(['css/app.css', 'js/app.js', 'js/public.js']);
  mix.browserSync({
    proxy: 'blog.app'
  });
});

// elixir((mix) => {
//   mix.phpUnit();
// });
