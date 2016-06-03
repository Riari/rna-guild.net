<?php namespace App\Providers;

use App\Support\Notifynder\EmailNotificationSender;
use Illuminate\Support\ServiceProvider;
use Notifynder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Notifynder::extend('sendWithEmail', function ($notification) {
            return new EmailNotificationSender($notification);
        });
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
