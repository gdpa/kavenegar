# Kavenegar notifications channel for Laravel 5.3+

[![Latest Version on Packagist](https://img.shields.io/packagist/v/gdpa/kavenegar.svg?style=flat-square)](https://packagist.org/packages/gdpa/kavenegar)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/gdpa/kavenegar/master.svg?style=flat-square)](https://travis-ci.org/gdpa/kavenegar)
[![StyleCI](https://styleci.io/repos/145205024/shield)](https://github.styleci.io/accounts/145205024)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gdpa/kavenegar/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gdpa/kavenegar/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/gdpa/kavenegar/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/gdpa/kavenegar/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/gdpa/kavenegar.svg?style=flat-square)](https://packagist.org/packages/gdpa/kavenegar)

This package makes it easy to sent [Kavenegar](https://kavenegarpush.com//) Notifications with Laravel 5.3+.

## Contents

- [Installation](#installation)
    - [Setting up the Kavenegar service](#setting-up-the-kavenegar-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install the package via composer:

``` bash
composer require gdpa/kavenegar
```

### Setting up the Kavenegar service

Add your Kavenegar REST API Key to your `config/services.php`:

```php
// config/services.php
...
'kavenegar' => [
    'api_key' => env('KAVENEGAR_API_KEY'), 
],
...
```

## Usage

There are two channels that you can use in your `via()` method inside the notification:
`KavenegarChannel` which represent `simple send` api and `KavenegarVerifyChannel` which provide `verify lookup` api.

``` php
use NotificationChannels\Kavenegar\KavenegarChannel;
use NotificationChannels\Kavenegar\KavenegarMessage;
use Illuminate\Notifications\Notification;

class ProjectCreated extends Notification
{
    public function via($notifiable)
    {
        return [KavenegarChannel::class];
    }

    public function toKavenegar($notifiable)
    {
        return KavenegarMessage::create()
            ->sender("your-desired-sender-number")
            ->message('Hello world');
    }
}
```

``` php
use NotificationChannels\Kavenegar\KavenegarVerifyChannel;
use NotificationChannels\Kavenegar\KavenegarMessage;
use Illuminate\Notifications\Notification;

class ProjectCreated extends Notification
{
    public function via($notifiable)
    {
        return [KavenegarVerifyChannel::class];
    }

    public function toKavenegar($notifiable)
    {
        return KavenegarMessage::create()
            ->template("your-template-key(Refer to Kavenegar Docs)")
            ->type('sms')
            ->token('your default token on your verify message template')
            ->token('additional token data. For example token10', 10);
    }
}
```

In order to let your Notification know which Kavenegar user you are targeting, add the `routeNotificationForKavenegar` method to your Notifiable model.

This method needs to return an array containing the mobile number of your receptor.

```php
public function routeNotificationForKavenegar()
{
    return [
        'mobile_number' => 'receptor mobile number',
    ];
}
```

### Available methods

- `sender('')`: Accepts a string value for setting sender number on kavenegar.
- `message()`: Accepts a string value for setting your sms message.
- `template()`: Accepts a string value for setting your sms template.
- `type()`: Accepts a string value for setting your service type (sms, voice, ...).
- `tokens()`: Accepts two string value for setting your tokens. Second string is optional and in case you don't provide it, it set your default token.


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email morteza.poussaneh@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Morteza Poussaneh](https://github.com/gdpa)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
