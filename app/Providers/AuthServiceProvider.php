<?php

namespace App\Providers;

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
        'App\Models\Device' => 'App\Policies\DevicePolicy',
        'App\Models\Report' => 'App\Policies\ReportPolicy',
        'App\Models\Project' => 'App\Policies\ProjectPolicy',
        'App\Models\Request' => 'App\Policies\RequestPolicy',
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
    }

    public static function validateCompanyEmail($userEmail)
    {
        foreach (COMPANY_EMAIL_DOMAIN as $domain) {
            $domainRegex = str_replace('.', '\.', $domain);
            if (preg_match('/^.+@' . $domainRegex . '$/', $userEmail)) {
                return true;
            }
        }

        return false;
    }
}
