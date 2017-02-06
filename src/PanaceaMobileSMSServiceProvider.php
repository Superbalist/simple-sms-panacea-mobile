<?php

namespace Superbalist\SimpleSMSPanaceaMobile;

use GuzzleHttp\Client;
use SimpleSoftwareIO\SMS\DriverManager;
use SimpleSoftwareIO\SMS\SMSServiceProvider;
use Superbalist\PanaceaMobile\PanaceaMobileAPI;

class PanaceaMobileSMSServiceProvider extends SMSServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/sms.php', 'sms');

        $this->registerManager();
        $this->registerCustomDriver();

        parent::register();
    }

    /**
     * Register the driver manager.
     */
    public function registerManager()
    {
        $this->app->singleton('sms.manager', function ($app) {
            return new DriverManager($app);
        });
    }

    /**
     * Register the custom PanaceaMobileAPI driver.
     */
    public function registerCustomDriver()
    {
        $manager = $this->app->make('sms.manager');
        /* @var DriverManager $manager */
        $manager->extend('panaceamobile', function ($app) {
            $config = $app['config']->get('sms.panacea_mobile', []);
            $guzzleClient = new Client();
            $client = new PanaceaMobileAPI($guzzleClient, $config['username'], $config['password']);
            return new PanaceaMobileSMS($client);
        });
    }

    /**
     * Register the correct driver based on the config file.
     */
    public function registerSender()
    {
        $this->app['sms.sender'] = $this->app->share(function ($app) {
            $manager = $app->make('sms.manager');
            /* @var DriverManager $manager */
            return $manager->driver();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array_merge(parent::provides(), ['sms.manager']);
    }
}
