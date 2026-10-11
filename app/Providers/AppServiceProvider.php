<?php

namespace App\Providers;

use App\Models\Message;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Évite l'erreur « Specified key was too long » sur les anciennes versions de MySQL
        Schema::defaultStringLength(191);

        Paginator::defaultView('partials.pagination');

        // Nombre de messages non lus, affiché dans le menu de l'admin
        View::composer('layouts.admin', function ($view) {
            $view->with('unreadCount', Message::unread()->count());
        });
    }
}
