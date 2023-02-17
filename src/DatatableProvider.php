<?php

namespace MikhailMouner\Datatable;

use Illuminate\Support\ServiceProvider;
use MikhailMouner\Datatable\Console\Commands\CreateDatatable;

class DatatableProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $appPath = __DIR__ . '/../stubs/';

        $this->publishes([
            $appPath => app_path('stubs/'),
        ], 'datatable-stubs');

        $this->commands([
            CreateDatatable::class,
        ]);
    }
}
