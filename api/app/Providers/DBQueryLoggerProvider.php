<?php

namespace App\Providers;

use DB;
use File;
use Illuminate\Support\ServiceProvider;

class DBQueryLoggerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function ($query) {
            $to_be_logged = sprintf(
                "%s_%s_",
                '[' . date('Y-m-d H:i:s') . ']',
                $query->sql . ' [' . implode(', ', $query->bindings) . ']',
            );
            $to_be_logged = str_replace('_', PHP_EOL, $to_be_logged);

            File::append(storage_path('/logs/query.log'), $to_be_logged);
        });
    }
}
