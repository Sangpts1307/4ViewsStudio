<?php

namespace App\Providers;

use App\Models\Concept;
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
    }
}
