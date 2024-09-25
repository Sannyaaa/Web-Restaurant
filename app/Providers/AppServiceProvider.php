<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Review;
use App\Models\Feedback;
use App\Policies\OrderPolicy;
use App\Policies\ReviewPolicy;
use App\Policies\FeedbackPolicy;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Gate;
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

    protected $policies = [
        Order::class => OrderPolicy::class,
        Review::class => ReviewPolicy::class,
        Feedback::class => FeedbackPolicy::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(UrlGenerator $url): void
    {
        //
        Gate::define('isStaf', function ($user)
        {
            return $user->role !== 'user';
        });

        Gate::define('isKitchen', function ($user)
        {
            return $user->role == 'kitchen' || $user->role == 'admin';
        });

        Gate::define('isService', function ($user)
        {
            return $user->role == 'service' || $user->role == 'admin';
        });

        Gate::define('isCashier', function ($user)
        {
            return $user->role == 'cashier' || $user->role == 'admin';
        });

        Gate::define('isAdmin', function ($user)
        {
            return $user->role == 'admin';
        });

        Gate::define('orderAccess', function ($user)
        {
            return $user->role == 'cashier' || $user->role == 'admin' || $user->role == 'service';
        });
        
    }

}
