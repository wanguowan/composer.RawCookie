<?php
/**
 * Created by PhpStorm.
 * User: wan
 * Date: 7/24/17
 * Time: 6:37 PM
 */
namespace Wan\RawCookie\Providers;

use Illuminate\Support\ServiceProvider;
use Wan\RawCookie\RawCookieJar;

class RawCookieServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('rawcookie', function ($app) {
            $config = $app['config']['session'];

            return (new RawCookieJar())->setDefaultPathAndDomain($config['path'], $config['domain'], $config['secure']);
        });
    }
}