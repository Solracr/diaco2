<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

//use Laravel\Passport;
 

//Passport::hashClientSecrets();
class AuthServiceProvider extends ServiceProvider
{

    
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerPolicies();

   

        //Passport::routes();

        /*$this->tokensExpireIn(now()->addDays(60));
        $this->refreshTokensExpireIn(now()->addDays(30));
        $this->personalAccessTokensExpireIn(now()->addMinutes(30));*/
        //
    }
}
