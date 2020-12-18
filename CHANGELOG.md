# Changelog

All notable changes to `myparcel-php-api` will be documented in this file.

## [Unreleased]

### Added
- Added `retail_network_id` to the `ServicePoint` resource. [`#50`](https://github.com/mvdnbrk/myparcel-php-api/pull/50)
- Added `ageCheck` shipping option. [`#42`](https://github.com/mvdnbrk/myparcel-php-api/pull/42)

### Fixed
- Use constants for `package_type` and `delivery_type`. [`ef759e1`](https://github.com/mvdnbrk/myparcel-php-api/commit/ef759e152325f7ea766b86393da2d151507d8c9f)

## [v2.2.0] - 2020-11-11

### Added
- Support for PHP 8. [`#38`](https://github.com/mvdnbrk/myparcel-php-api/pull/38)
- Added `link` and `link_portal` attribute to the `TrackTrace` class. [`#40`](https://github.com/mvdnbrk/myparcel-php-api/pull/40)

### Removed
- Dropped support for PHP 7.2. [`a97588d`](https://github.com/mvdnbrk/myparcel-php-api/commit/a97588dcdbd52cd5f2eeb6ec36f99e89e38269e1)

## [v2.1.0] - 2020-09-18

### Added
- PHP 7 type hints and return type declarations. [`#36`](https://github.com/mvdnbrk/myparcel-php-api/pull/36)

## [v2.0.4] - 2020-08-08

### Added
- Added support for `tightenco/collect` v8.0. [`#33`](https://github.com/mvdnbrk/myparcel-php-api/pull/33)

## [v2.0.3] - 2020-06-28

### Added
- Added support for `guzzlehttp/guzzle` v7.0. [`be1c50a`](https://github.com/mvdnbrk/myparcel-php-api/commit/be1c50ab393251a251295d3de6d0b6617abb556b)

## [v2.0.2] - 2020-03-13

### Added
- Added support for `tightenco/collect` v7.0. [`#29`](https://github.com/mvdnbrk/myparcel-php-api/pull/29)

## [v2.0.1] - 2019-11-15

### Removed
- Removed Laravel package discovery in composer.json. [`f005daa`](https://github.com/mvdnbrk/myparcel-php-api/commit/f005daa68021d8c8aae6463966beba66173396bc)

## [v2.0.0] - 2019-11-15

### Removed
- Removed support for Laravel. Please use this [package](https://github.com/mvdnbrk/laravel-myparcel) instead. [`#28`](https://github.com/mvdnbrk/myparcel-php-api/pull/28)

## [v1.0.2] - 2019-11-15

### Changed
- Updated dependencies. [`2b1be49`](https://github.com/mvdnbrk/myparcel-php-api/commit/2b1be49068b649437fef5abec45e061bc7088fd1), [`b581b9c`](https://github.com/mvdnbrk/myparcel-php-api/commit/b581b9c37070e5f60691996a875608c661477af7)

## [v1.0.1] - 2019-10-13

### Changed
- Updated dependencies. [`3ef4cd3`](https://github.com/mvdnbrk/myparcel-php-api/commit/3ef4cd311b98c17df113ba928c1830f386bb5cc7)

## [v1.0.0] - 2019-04-26

- Release of v1.0.0, no notable changes.

## [v0.9.2] - 2019-04-26

### Added
- Added a `setFormatA4` method to change the default label format from A6 to A4. [`#24`](https://github.com/mvdnbrk/myparcel-php-api/pull/24)

## [v0.9.1] - 2019-04-26

### Added
- Added a `setLabel` method to configure the label format and position. [`#23`](https://github.com/mvdnbrk/myparcel-php-api/pull/23)

## [v0.9.0] - 2019-03-20

### Changed
- The `get()` method of the `servicePoints` endpoint has changed. [`#20`](https://github.com/mvdnbrk/myparcel-php-api/pull/20)
- The `deliveryOptions` endpint is renamed to `servicePoints`. [`#19`](https://github.com/mvdnbrk/myparcel-php-api/pull/19)
- The `PickupLocation` class is renamed to `ServicePoint`. [`#18`](https://github.com/mvdnbrk/myparcel-php-api/pull/18)

## [v0.8.0] - 2019-03-20

### Changed
- The `opening_hours` attribute is converted to an array. [`#17`](https://github.com/mvdnbrk/myparcel-php-api/pull/17)
- Getting delivery options now returns a collection of `PickupLocation` objects. [`#16`](https://github.com/mvdnbrk/myparcel-php-api/pull/16)
- `location_id` is renamed to `id` on the `PickupLocation` object. [`#15`](https://github.com/mvdnbrk/myparcel-php-api/pull/15)
- `location_name` is renamed to `name` on the `PickupLocation` object. [`#15`](https://github.com/mvdnbrk/myparcel-php-api/pull/15)

## [v0.7.3] - 2019-03-15

### Changed
- Updated dependencies. [`e26e5c8`](https://github.com/mvdnbrk/myparcel-php-api/commit/e26e5c8b99c51ba7245323751841b3293ac8b38a)

## [v0.7.2] - 2019-03-15

### Changed
- Changed `final` to `isDelivered` on a TrackTrace resource. [`4fb7feb`](https://github.com/mvdnbrk/myparcel-php-api/commit/4fb7feb39511f2321c65d7317598bb1b3f101298)

## [v0.7.1] - 2019-02-22

### Fixed
- Fixed an issue returning Shipment resource with correct values. [`aef9176`](https://github.com/mvdnbrk/myparcel-php-api/commit/aef9176f7659536da7f0a15ee00c579b09bd09ab)

## [v0.7.0] - 2019-02-19

### Changed
- Removed person attribute in favor of first_name and last_name. [`067dbc0`](https://github.com/mvdnbrk/myparcel-php-api/commit/067dbc0e6a31816c40a2af6ba60f5affae5abe0c)

## [v0.6.2] - 2019-02-19

### Changed
- The `setApiKey()` now returns the `Client` instance to allow method chaining. [`dacefc2`](https://github.com/mvdnbrk/myparcel-php-api/commit/dacefc2190614dbe6ddafa1e4e83d222a00f786c)
- Improved the registration of publishable resources. [`963383e`](https://github.com/mvdnbrk/myparcel-php-api/commit/963383efdbcebb9b8b7934738b9fa8836ca92aaa)

### Fixed
- Fixed unneeded `json_encode()`. [`677b728`](https://github.com/mvdnbrk/myparcel-php-api/commit/677b7285e33bc4a6d1802ef1071fbccbd990b094)

## [v0.6.1] - 2019-02-07

### Changed
- Unify `tests` namespace. [`95edf57`](https://github.com/mvdnbrk/myparcel-php-api/commit/95edf5780eaa7416d0ba2ff7586578de0de2761e)

## [v0.6.0] - 2019-01-20

### Fixed
- Fixed a change in the MyParcel API response. [`6d446e1`](https://github.com/mvdnbrk/myparcel-php-api/commit/6d446e1fda221da463076cd59f822a87666e3aa4)

## [v0.5.0] - 2018-09-03

### Added
- Adds a test for creating a valid PickupLocation instance. [`d5fea6cdbf`](https://github.com/mvdnbrk/myparcel-php-api/commit/d5fea6cdbf4a36e4bbcddd459cfe840489879d56)
- Location may be used to set a location name on PickupLocation object. [`8c391b35`](https://github.com/mvdnbrk/myparcel-php-api/commit/8c391b358bee7e0931b0315be91a6fb45cb64a13)
- Phone number may be used as an alias to phone on PickupLocation object. [`3c4d34a`](https://github.com/mvdnbrk/myparcel-php-api/commit/3c4d34ad7433bc53a125ff0f7d51bafcb33dc1db)

### Changed
- Latitude and longitude should be converted to float. [`2b05698`](https://github.com/mvdnbrk/myparcel-php-api/commit/2b05698e3bb63a7bb54e470d5cba475dbd996785)
- Refactors code for creating the pick up points. [`3056552`](https://github.com/mvdnbrk/myparcel-php-api/commit/305655203404f24f121ec299a39b6166a7d5cf63)

## [v0.4.1] - 2018-08-31

### Added
- Added "myparcel" to the provides() method in MyParcelServiceProvider. [`7e1aff8`](https://github.com/mvdnbrk/myparcel-php-api/commit/7e1aff8686e77ededf79d7819cc50225e1118627)

## [v0.4.0] - 2018-08-31

### Added
- Added support for usage with [Laravel](https://laravel.com/). [`415af52`](https://github.com/mvdnbrk/myparcel-php-api/commit/415af527d369b8903aa1d2e326027212afd444b5)

## [v0.3.0] - 2018-08-29

### Added
- Added TrackTrace functionality. [`7800d85`](https://github.com/mvdnbrk/myparcel-php-api/commit/7800d85f37bc41c474edecef15f3b7339ff63699)

### Removed
- Removed unused use statements. [`a8c2c57`](https://github.com/mvdnbrk/myparcel-php-api/commit/a8c2c577af4470b44ed3dd9a6906d56f4d6524ef)

## [v0.2.0] - 2018-08-28

### Added

- Added a test for retrieving a label with an invalid shipment id. [`3017b1e`](https://github.com/mvdnbrk/myparcel-php-api/commit/3017b1e8d22a7583335131fe76a33bbbb8206c08)
- Added tests for retrieving non-existent shipments. [`3889c0c`](https://github.com/mvdnbrk/myparcel-php-api/commit/3889c0cfe0761282086a40b3c6919ac4f98ebfe4)
- Added street_additional_info property to Address. [`343e09b`](https://github.com/mvdnbrk/myparcel-php-api/commit/343e09bda5052b5613ca5d8adfdc665cdf8d38f0)
- Added a Label resource. [`3e8c1d2`](https://github.com/mvdnbrk/myparcel-php-api/commit/3e8c1d283c4349293b2a94a29f965aa31c37396e)

## [v0.1.1] - 2018-08-26

### Added
- Added shipment to array test. [`f153ce0`](https://github.com/mvdnbrk/myparcel-php-api/commit/f153ce0d619ffa63591a07120ef2322ddd17d392)

## [v0.1.0] - 2018-08-24

### Initial release

[Unreleased]: https://github.com/mvdnbrk/myparcel-php-api/compare/v2.2.0...HEAD
[v2.2.0]: https://github.com/mvdnbrk/myparcel-php-api/compare/v2.1.0...v2.2.0
[v2.1.0]: https://github.com/mvdnbrk/myparcel-php-api/compare/v2.0.4...v2.1.0
[v2.0.4]: https://github.com/mvdnbrk/myparcel-php-api/compare/v2.0.3...v2.0.4
[v2.0.3]: https://github.com/mvdnbrk/myparcel-php-api/compare/v2.0.2...v2.0.3
[v2.0.2]: https://github.com/mvdnbrk/myparcel-php-api/compare/v2.0.1...v2.0.2
[v2.0.1]: https://github.com/mvdnbrk/myparcel-php-api/compare/v2.0.0...v2.0.1
[v2.0.0]: https://github.com/mvdnbrk/myparcel-php-api/compare/v1.0.2...v2.0.0
[v1.0.2]: https://github.com/mvdnbrk/myparcel-php-api/compare/v1.0.1...v1.0.2
[v1.0.1]: https://github.com/mvdnbrk/myparcel-php-api/compare/v1.0.0...v1.0.1
[v1.0.0]: https://github.com/mvdnbrk/myparcel-php-api/compare/v0.9.2...v1.0.0
[v0.9.2]: https://github.com/mvdnbrk/myparcel-php-api/compare/v0.9.1...v0.9.2
[v0.9.1]: https://github.com/mvdnbrk/myparcel-php-api/compare/v0.9.0...v0.9.1
[v0.9.0]: https://github.com/mvdnbrk/myparcel-php-api/compare/v0.8.0...v0.9.0
[v0.8.0]: https://github.com/mvdnbrk/myparcel-php-api/compare/v0.7.3...v0.8.0
[v0.7.3]: https://github.com/mvdnbrk/myparcel-php-api/compare/v0.7.2...v0.7.3
[v0.7.2]: https://github.com/mvdnbrk/myparcel-php-api/compare/v0.7.1...v0.7.2
[v0.7.1]: https://github.com/mvdnbrk/myparcel-php-api/compare/v0.7.0...v0.7.1
[v0.7.0]: https://github.com/mvdnbrk/myparcel-php-api/compare/v0.6.2...v0.7.0
[v0.6.2]: https://github.com/mvdnbrk/myparcel-php-api/compare/v0.6.1...v0.6.2
[v0.6.1]: https://github.com/mvdnbrk/myparcel-php-api/compare/v0.6.0...v0.6.1
[v0.6.0]: https://github.com/mvdnbrk/myparcel-php-api/compare/v0.5.0...v0.6.0
[v0.5.0]: https://github.com/mvdnbrk/myparcel-php-api/compare/v0.4.1...v0.5.0
[v0.4.1]: https://github.com/mvdnbrk/myparcel-php-api/compare/v0.4.0...v0.4.1
[v0.4.0]: https://github.com/mvdnbrk/myparcel-php-api/compare/v0.3.0...v0.4.0
[v0.3.0]: https://github.com/mvdnbrk/myparcel-php-api/compare/v0.2.0...v0.3.0
[v0.2.0]: https://github.com/mvdnbrk/myparcel-php-api/compare/v0.1.1...v0.2.0
[v0.1.1]: https://github.com/mvdnbrk/myparcel-php-api/compare/v0.1.0...v0.1.1
[v0.1.0]: https://github.com/mvdnbrk/myparcel-php-api/tree/v0.1.0
