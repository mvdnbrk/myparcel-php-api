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
$ composer require mvdnbrk/myparcel-php-api
```

## Getting started

Initialize the MyParcel client and set your API key.

``` php
$myparcel = \Mvdnbrk\MyParcel\Client();
$myparcel->setApiKey('your-api-key');
```

### Create a parcel
``` php
$parcel = \Mvdnbrk\MyParcel\Resources\Parcel([
    'reference' => 'your own reference for the parcel',
    'recipient' => [
        'person' => 'John Doe',
        'street' => 'Poststraat',
        'number' => '1',
        'number_suffix' => 'A',
        'postal_code' => '1234AA',
        'city' => 'Amsterdam',
        'cc' => 'NL,
    ]
]);
```

### Create the shipment
``` php
$shipment = $myparcel->shipments->create($parcel)
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

If you discover any security related issues, please email mvdnbrk@gmail.com instead of using the issue tracker.

## Credits

- [Mark van den Broek][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/mvdnbrk/myparcel-php-api.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/mvdnbrk/myparcel-php-api/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/mvdnbrk/myparcel-php-api.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/mvdnbrk/myparcel-php-api.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/mvdnbrk/myparcel-php-api.svg?style=flat-square
[ico-style-ci]: https://styleci.io/repos/72292364/shield?branch=master

[link-packagist]: https://packagist.org/packages/mvdnbrk/myparcel-php-api
[link-travis]: https://travis-ci.org/mvdnbrk/myparcel-php-api
[link-scrutinizer]: https://scrutinizer-ci.com/g/mvdnbrk/myparcel-php-api/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/mvdnbrk/myparcel-php-api
[link-downloads]: https://packagist.org/packages/mvdnbrk/myparcel-php-api
[link-author]: https://github.com/mvdnbrk
[link-contributors]: ../../contributors
[link-style-ci]: https://styleci.io/repos/72292364
