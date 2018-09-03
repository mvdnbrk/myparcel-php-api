# Changelog

All notable changes to `myparcel-php-api` will be documented in this file.

## [Unreleased]

## [0.5.0] - 2018-09-03

### Added
- Adds a test for creating a valid PickupLocation instance. [`d5fea6cdbf`](https://github.com/mvdnbrk/myparcel-php-api/commit/d5fea6cdbf4a36e4bbcddd459cfe840489879d56)
- Location may be used to set a location name on PickupLocation object. [`8c391b35`](https://github.com/mvdnbrk/myparcel-php-api/commit/8c391b358bee7e0931b0315be91a6fb45cb64a13)
- Phone number may be used as an alias to phone on PickupLocation object. [`3c4d34a`](https://github.com/mvdnbrk/myparcel-php-api/commit/3c4d34ad7433bc53a125ff0f7d51bafcb33dc1db)

### Changed
- Latitude and longitude should be converted to float. [`2b05698`](https://github.com/mvdnbrk/myparcel-php-api/commit/2b05698e3bb63a7bb54e470d5cba475dbd996785)
- Refactors code for creating the pick up points. [`3056552`](https://github.com/mvdnbrk/myparcel-php-api/commit/305655203404f24f121ec299a39b6166a7d5cf63)

## [0.4.1] - 2018-08-31

### Added
- Added "myparcel" to the provides() method in MyParcelServiceProvider. [`7e1aff8`](https://github.com/mvdnbrk/myparcel-php-api/commit/7e1aff8686e77ededf79d7819cc50225e1118627)

## [0.4.0] - 2018-08-31

### Added
- Added support for usage with [Laravel](https://laravel.com/). [`415af52`](https://github.com/mvdnbrk/myparcel-php-api/commit/415af527d369b8903aa1d2e326027212afd444b5)

## [0.3.0] - 2018-08-29

### Added
- Added TrackTrace functionality. [`7800d85`](https://github.com/mvdnbrk/myparcel-php-api/commit/7800d85f37bc41c474edecef15f3b7339ff63699)

### Removed
- Removed unused use statements. [`a8c2c57`](https://github.com/mvdnbrk/myparcel-php-api/commit/a8c2c577af4470b44ed3dd9a6906d56f4d6524ef)

## [0.2.0] - 2018-08-28

### Added

- Added a test for retrieving a label with an invalid shipment id. [`3017b1e`](https://github.com/mvdnbrk/myparcel-php-api/commit/3017b1e8d22a7583335131fe76a33bbbb8206c08)
- Added tests for retrieving non-existent shipments. [`3889c0c`](https://github.com/mvdnbrk/myparcel-php-api/commit/3889c0cfe0761282086a40b3c6919ac4f98ebfe4)
- Added street_additional_info property to Address. [`343e09b`](https://github.com/mvdnbrk/myparcel-php-api/commit/343e09bda5052b5613ca5d8adfdc665cdf8d38f0)
- Added a Label resource. [`3e8c1d2`](https://github.com/mvdnbrk/myparcel-php-api/commit/3e8c1d283c4349293b2a94a29f965aa31c37396e)

## [0.1.1] - 2018-08-26

### Added
- Added shipment to array test. [`f153ce0`](https://github.com/mvdnbrk/myparcel-php-api/commit/f153ce0d619ffa63591a07120ef2322ddd17d392)

## [0.1.0] - 2018-08-24

### Initial release

[Unreleased]: https://github.com/mvdnbrk/myparcel-php-api/compare/v0.5.0...HEAD
[0.4.1]: https://github.com/mvdnbrk/postmark-inbound/compare/v0.4.1...v0.5.0
[0.4.0]: https://github.com/mvdnbrk/postmark-inbound/compare/v0.3.0...v0.4.0
[0.3.0]: https://github.com/mvdnbrk/postmark-inbound/compare/v0.2.0...v0.3.0
[0.2.0]: https://github.com/mvdnbrk/postmark-inbound/compare/v0.1.1...v0.2.0
[0.1.1]: https://github.com/mvdnbrk/postmark-inbound/compare/v0.1.0...v0.1.1
[0.1.0]: https://github.com/mvdnbrk/myparcel-php-api/tree/v0.1.0
