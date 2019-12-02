<?php

namespace TradefiUBA\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'TradefiUBA\Model' => 'TradefiUBA\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //

        // Only Sender & Recipients
        Gate::define('view-message', function ($user, $message) {
          return ( $user->id == $message->FromID || in_array($user->id, $message->recipients->pluck('id')->toArray()) );
        });
    }
}
