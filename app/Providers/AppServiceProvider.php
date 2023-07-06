<?php

namespace App\Providers;

use App\Helpers\ProtocolCheck;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The array to hold repositories.
     *
     * @var array
     */
    protected $repositories = [
        \App\Repositories\Config\Ads\AdsRepository::class                       => \App\Repositories\Config\Ads\AdsRepositoryImplement::class,
        \App\Repositories\Config\Client\ClientRepository::class                 => \App\Repositories\Config\Client\ClientRepositoryImplement::class,
        \App\Repositories\Config\HotelRoom\HotelRoomRepository::class           => \App\Repositories\Config\HotelRoom\HotelRoomRepositoryImplement::class,
        \App\Repositories\Config\UserData\UserDataRepository::class             => \App\Repositories\Config\UserData\UserDataRepositoryImplement::class,
        \App\Repositories\Config\SocialPlugin\SocialPluginRepository::class     => \App\Repositories\Config\SocialPlugin\SocialPluginRepositoryImplement::class,
        \App\Repositories\Config\VoucherPrint\VoucherPrintRepository::class     => \App\Repositories\Config\VoucherPrint\VoucherPrintRepositoryImplement::class,
        \App\Repositories\Client\Voucher\VoucherRepository::class               => \App\Repositories\Client\Voucher\VoucherRepositoryImplement::class,
        \App\Repositories\Client\UsersData\UsersDataRepository::class           => \App\Repositories\Client\UsersData\UsersDataRepositoryImplement::class
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $implement) {
            $this->app->bind($interface, $implement);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* Checks if the protocol is https and forces it to be https. */
        if (ProtocolCheck::check()) {
            //code...
            URL::forceScheme('https');
        }
        /* Sets the default string length for database migrations to 200 characters. */
        Schema::defaultStringLength(200);
    }
}
