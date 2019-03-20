<a href="https://www.myparcel.nl" target="_blank"><img src="https://assets.myparcel.nl/ui/corporate/logo-myparcel-alt.svg" alt="MyParcel" width="70" height="70"></a>

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

## Installation

You can install the package via composer:

``` bash
composer require mvdnbrk/myparcel-php-api
```

## Getting started

Initialize the MyParcel client and set your API key:

``` php
$myparcel = new \Mvdnbrk\MyParcel\Client();

$myparcel->setApiKey('your-api-key');
```

### Create a parcel

``` php
$parcel = new \Mvdnbrk\MyParcel\Resources\Parcel([
    'reference' => 'your own reference for the parcel',
    'recipient' => [
        'first_name' => 'John',
        'last_name' => 'Doe'
        'street' => 'Poststraat',
        'number' => '1',
        'number_suffix' => 'A',
        'postal_code' => '1234AA',
        'city' => 'Amsterdam',
        'cc' => 'NL',
    ]
]);
```

### Create the shipment

``` php
$shipment = $myparcel->shipments->create($parcel);

// Get the `id` of the shipment. You may save this value for later reference.
$shipment->id;
```

You have created your first shipment!

### Retrieving a label

A label can be retrieved by using `$shipment->id`. This will return a label in A6 format as a string.

```
$myparcel->labels->get($shipment->id);
```
Or you may pass the `Shipment` instance directly to this method:
```
$myparcel->labels->get($shipment);
```

### Setting delivery options for a parcel

You can set delivery options for a parcel by passing in the options directly when you create a parcel:

``` php
$parcel = new \Mvdnbrk\MyParcel\Resources\Parcel([
    ...
    'recipient' => [
        ...
    ],
    'options' => [
        'description' => 'Description on the label',
        'signature' => true,   
        ...
    ],
]);
```

Or you may use a method like `signature`, `onlyRecipient`, `returnToSender` and `labelDescription`.  
You may call any of these after constructing the parcel.
``` php
$parcel->onlyRecipient()
       ->returnToSender()
       ->signature()
       ->labelDescription('Some description.');
```

**Mailbox package**

This package type is only available for shipments in the Netherlands that fit in a standard mailbox.

``` php
$parcel->mailboxpackage();
```

### Send a shipment to a service point

You may send a parcel to a PostNL service point where a customer can pick up the parcel:

``` php
$parcel = new \Mvdnbrk\MyParcel\Resources\Parcel([
    'recipient' => [
        ...
    ],
    'pickup' => [
        'name' => 'Name of the location',
        'street' => 'Poststraat',
        'number' => '1',
        'postal_code' => '1234AA',
        'city' => 'Amsterdam',
        'cc' => 'NL,
    ]
]);
```

### Retrieving service points

```php
$servicepoints = $myparcel->servicePoints->setPostalcode('1234AA')->setHousenumber('1')->get();
```

This will return a collection of `ServicePoint` objects:

```
$servicepoints->each(function ($item) {
    $item->id;
    $item->name;
    $item->latitude;
    $item->longitude;
    $item->distance;
    $item->distanceForHumans();
    $item->opening_hours;
});
```

### Get a shipment

You can get a shipment by `id` or your own reference.

``` php
$shipment = $myparcel->shipments->get($id);

$shipment = $myparcel->shipments->getByReference('your own reference');

// Get the barcode for the shipment:
$shipment->barcode;

// Get the current status:
$shipment->status;
```

### Tracking a shipment

You can get detailed track and trace information for a shipment.

``` php
$tracktrace = $myparcel->tracktrace->get($id);

// Check if the shipment is delivered:
$tracktrace->isDelivered;

// Get current state of the shipment:
$tracktrace->code;
$tracktrace->description;
$tracktrace->datetime;

// Get all traces for the shipment, this will return a collection with
// all traces in descending order, including the current state:
$tracktrace->items;

// Convert all items to an array:
$tracktrace->items->all()
```

## Usage with Laravel

Add your MyParcel API key to the `.env` file:

```
MYPARCEL_API_KEY=YOUR-API-KEY-HERE
```

You can resolve a configured instance of `Mvdnbrk\MyParcel\Client` out of the container:
```
app('myparcel')->shipments->create($parcel);
```

## Changelog

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
