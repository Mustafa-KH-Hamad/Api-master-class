<?php

namespace App\Providers;

use App\Http\Requests\V1\BaseTicketRequest;
use App\Http\Requests\V1\TicketRequest;
use App\Models\User;
use App\Models\V1\ticket;
use App\Policies\V1\TicketPolicy;
use App\Policies\V1\UserPolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        Password::defaults(function(){
            return Password::min(8)->
                            max(255)->
                            letters()->
                            symbols()->
                            mixedCase();
        });
        Gate::policy(ticket::class,TicketPolicy::class);
        Gate::policy(User::class,UserPolicy::class);
    }
}
