<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TimestampProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindMethod(TimestampJob::class.'@handle',
                function($job, $app)
                {
                    return $job->handle();
                });
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
