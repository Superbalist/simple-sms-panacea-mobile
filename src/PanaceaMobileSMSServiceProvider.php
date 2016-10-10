<?php

namespace Superbalist\SimpleSMSPanaceaMobile;

use GuzzleHttp\Client;
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

        parent::register();
    }

    /**
     * Register the correct driver based on the config file.
     */
    public function registerSender()
    {
        parent::registerSender();

        $this->app['sms.sender']->extend('panaceamobile', function () {
            $client = new Client();
            // TODO: set username and password
            return new PanaceaMobileAPI($client);
        });
    }
}
