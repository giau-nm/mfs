<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Models\Request;
use App\Models\Device;
use App\Observers\RequestObserver;
use App\Observers\DeviceObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('max_date_request', 'App\Http\Validators\CustomValidator@maxDateRequest');
        Validator::replacer('max_date_request', function ($message, $attribute, $rule, $parameters) {
            $requestData = $this->app->request->all();
            $message = str_replace(':start_date', $requestData[$parameters[0]], $message);

            return str_replace(':max_date', $parameters[1], $message);
        });

        Request::observe(RequestObserver::class);
        Device::observe(DeviceObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
