<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Tag;
use App\Post;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Listen for post updates and clean orphan tags
        Post::updated(function(){
            Tag::doesntHave('posts')->delete();
        });
        // Listen for post deletions and clean orphan tags
        Post::deleted(function() {
            Tag::doesntHave('posts')->delete();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // ide helper in development
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
