<?php

namespace App\Providers;

use App\Models\Concept;
use App\Models\User;
use Google\Service\Dataproc\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        View::composer('clients.layouts.header', function ($view) {
            $concepts = Concept::all();
    
            $view->with('concepts_header', $concepts);
        });

        View::composer('staff.layouts.sidebar', function ($view) {
            $userId = Session('user_id');
            $user = User::find($userId);
            $lastName = collect(explode(' ', trim($user->name)))->last();
    
            $view->with('user_name', $lastName);
        });

    }
}
