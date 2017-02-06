# simple-sms-panacea-mobile

An adapter for the [simple-sms](https://github.com/SimpleSoftwareIO/simple-sms) Laravel library for sending SMSs via the [Panacea Mobile](https://www.panaceamobile.com) API

[![Author](http://img.shields.io/badge/author-@superbalist-blue.svg?style=flat-square)](https://twitter.com/superbalist)
[![Build Status](https://img.shields.io/travis/Superbalist/simple-sms-panacea-mobile/master.svg?style=flat-square)](https://travis-ci.org/Superbalist/simple-sms-panacea-mobile)
[![StyleCI](https://styleci.io/repos/70465005/shield?branch=master)](https://styleci.io/repos/70465005)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/superbalist/simple-sms-panacea-mobile.svg?style=flat-square)](https://packagist.org/packages/superbalist/simple-sms-panacea-mobile)
[![Total Downloads](https://img.shields.io/packagist/dt/superbalist/simple-sms-panacea-mobile.svg?style=flat-square)](https://packagist.org/packages/superbalist/simple-sms-panacea-mobile)


## Installation

```bash
composer require superbalist/simple-sms-panacea-mobile
```

The package has a default configuration which uses the following environment variables.
```
PANACEA_MOBILE_USERNAME=null
PANACEA_MOBILE_PASSWORD = null
```

If you would prefer to configure manually, you will need to first publish the simplesms package configuration using Artisan.
```bash
php artisan vendor:publish --provider="SimpleSoftwareIO\SMS\SMSServiceProvider"
```

You then need to append the following to the generated config at `app/config/sms.php`.
```php
// ...
'panacea_mobile' => [
    'username' => env('PANACEA_MOBILE_USERNAME'),
    'password' => env('PANACEA_MOBILE_PASSWORD')
],
```

Register the service provider in app.php
```php
'providers' => [
    // ...
    Superbalist\SimpleSMSPanaceaMobile\PanaceaMobileSMSServiceProvider::class,
]
```

## Usage

```php
// if 'panacea_mobile' is your default simplesms driver - `SMS_DRIVER`
$sms = app('sms'); /** @var \SimpleSoftwareIO\SMS\SMS $sms */

// send a simple message
$sms->send('This is my message content', [], function (OutgoingMessage $sms) {
    $sms->to('+27000000000');
});

// send a message from a view file
$viewData = [
    'lorem' => 'ipsum',
];
$sms->send('path.to.my.view.file' $viewData, function (OutgoingMessage $sms) {
    $sms->to('+27000000000');
});

// if 'panacea_mobile' is not your default driver
$sms->driver('panacea_mobile')->send('This is my message content', [], function (OutgoingMessage $sms) {
    $sms->to('+27000000000');
});

// see https://www.simplesoftware.io/docs/simple-sms#docs-usage for more usage examples
```
