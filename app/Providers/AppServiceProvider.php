<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Response::macro('success', function ($data, $status = 200) {
            return response()->json([
                'status_code' => $status,
                'status' => 'success',
                'data' => $data
            ], $status);
        });

        Response::macro('error', function ($data, $message, $status = 400) {
            return response()->json([
                'status_code' => $status,
                'status' => 'error',
                'message' => $message
            ], $status);
        });
    }
}