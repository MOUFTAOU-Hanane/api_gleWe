<?php

namespace App\Providers;

use App\Interfaces\OperationRepositoryInterface;
use App\Interfaces\AuthRepositoryInterface;
use App\Repositories\OperationRepository;
use App\Repositories\AuthRepository;
use App\Interfaces\ParamsRepositoryInterface;
use App\Repositories\ParamsRepository;


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
        $this->app->bind(OperationRepositoryInterface::class, OperationRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(ParamsRepositoryInterface::class, ParamsRepository::class);

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
