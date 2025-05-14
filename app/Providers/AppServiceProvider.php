<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Employee;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('layouts.pos', function ($view) {
            $user = Auth::user();
            $employee = null;

            if ($user) {
                $employee = Employee::where('user_id', $user->id)->first();
            }

        $view->with('employee', $employee);
    });
    }   
}
