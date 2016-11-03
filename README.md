![MyParcel](https://www.myparcel.nl/assets/images/logo-myparcel-alt.png)

# myparcel-php-api

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![StyleCI][ico-style-ci]][link-style-ci]
[![Total Downloads][ico-downloads]][link-downloads]

[MyParcel](https://www.myparcel.nl/) makes sending packages easy.

[MyParcel API documentation](https://myparcelnl.github.io/api/)

## Requirements

To use the MyParcel API client, the following things are required:

+ Get a free [MyParcel account](https://backoffice.myparcel.nl/registration)
+ Generate your [API Key](https://backoffice.myparcel.nl/settings)
+ Now you're ready to use the MyParcel API client.
+ PHP >= 5.6

## Install

The easiest way to install the MyParcel API client is to rquire it with [Composer](https://getcomposer.org/doc/00-intro.md)

``` bash
$ composer require heyhoo/myparcel-php-api
```

## Usage

``` php
$myparcel = new MyParcel_API_Client;
$myparcel->send();
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email mark@heyhoo.nl instead of using the issue tracker.

## Credits

- [Mark van den Broek][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/heyhoo/myparcel-php-api.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/heyhoo/myparcel-php-api/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/heyhoo/myparcel-php-api.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/heyhoo/myparcel-php-api.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/heyhoo/myparcel-php-api.svg?style=flat-square
[ico-style-ci]: https://styleci.io/repos/72292364/shield?branch=master

[link-packagist]: https://packagist.org/packages/heyhoo/myparcel-php-api
[link-travis]: https://travis-ci.org/heyhoo/myparcel-php-api
[link-scrutinizer]: https://scrutinizer-ci.com/g/heyhoo/myparcel-php-api/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/heyhoo/myparcel-php-api
[link-downloads]: https://packagist.org/packages/heyhoo/myparcel-php-api
[link-author]: https://github.com/heyhoo
[link-contributors]: ../../contributors
[link-style-ci]: https://styleci.io/repos/72292364
