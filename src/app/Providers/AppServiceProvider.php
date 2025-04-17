<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

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
        view()->composer('*', function () {
            if (Auth::check()) {
                $user = Auth::user();

                if (
                    is_null($user->zipcode) &&
                    is_null($user->address) &&
                    Request::path() !== 'mypage/profile'
                ) {
                    redirect('/mypage/profile')->send();
                }
            }
        });
    }
}
