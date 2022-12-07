<?php

namespace App\Providers;

use App\Repository\CollectionRepository;
use App\Repository\FileRepository;
use App\Repository\ICollectionRepository;
use App\Repository\IFileRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            IFileRepository::class, FileRepository::class
        );
        $this->app->bind(
            ICollectionRepository::class, CollectionRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
