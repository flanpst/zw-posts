<?php

namespace Modules\Posts\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Modules\Posts\Models\Post;
use Modules\Posts\Models\PostCategory;
use Modules\Posts\Policies\PostCategoryPolicy;
use Modules\Posts\Policies\PostPolicy;
use Modules\Posts\Repositories\Contracts\PostCategoryRepositoryInterface;
use Modules\Posts\Repositories\Contracts\PostRepositoryInterface;
use Modules\Posts\Repositories\Core\Eloquent\EloquentPostCategoryRepository;
use Modules\Posts\Repositories\Core\Eloquent\EloquentPostRepository;

class PostsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerRoutes();

        $this->loadMigrationsFrom(__DIR__.'/../Migrations');

        // Gate::policy(Post::class, PostPolicy::class);
        // Gate::policy(PostCategory::class, PostCategoryPolicy::class);
    }

    public function register()
    {
        $this->app->singleton(Post::class, function ($app) {
            return new Post();
        });

        $this->app->singleton(PostCategory::class, function ($app) {
            return new PostCategory();
        });

        $this->app->bind(
            PostRepositoryInterface::class,
            EloquentPostRepository::class
        );
        $this->app->bind(
            PostCategoryRepositoryInterface::class,
            EloquentPostCategoryRepository::class
        );
    }

    private function registerRoutes()
    {
        Route::prefix('api')
            ->middleware(['auth:sanctum'])
            ->namespace('Modules\Posts\Http\Controllers')
            ->group(function () {
                require __DIR__.'/../Routes/api.php';
            });
    }

}
