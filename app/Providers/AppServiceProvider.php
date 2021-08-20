<?php

namespace App\Providers;

use App\Mail\VerifyMail;
use Illuminate\Support\ServiceProvider;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function ($query) {
            Log::info(
                $query->sql,
                $query->bindings,
                $query->time
            );
        });
        // VerifyEmail::toMailUsing(function ($notifiable, $verificationUrl) {
        //     return (new MailMessage)
        //         ->subject('Verify your email address')
        //         ->markdown('emails.verifymail', ['url' => $verificationUrl]);
        // });
        // ResetPassword::toMailUsing(function ($notifiable, $verificationUrl) {
        //     return (new MailMessage)
        //         ->subject('Verify your email address')
        //         ->markdown('emails.verifymail', ['url' => $verificationUrl]);
        // });
    }
}
