# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

## 2.0-beta8 - 2022-02-01

### Fixed

- Added missing `HasTranslations` trait to `ProductVariant` model.

### Changed

- When adding addresses via the `CartManager` we update any existing addresses rather than removing and re adding.
- When generating handles for models, we have moved to a forced `snake` case. i.e. `some_handle`. By [@itcyborg](https://github.com/itcyborg)

### Added

- Added `scopeDefault` to the `Url` model.
- Added a new `defaultUrl` relationship to models using the `HasUrls` trait.
- Added new `PricingManager` class to deal with price fetching on purchasable objects.
- Allow hub path to be configurable in `system` config. By ([@ryanmitchell](https://github.com/ryanmitchell))

[View Changes](https://github.com/getcandy/core/compare/2.0-beta7...2.0-beta8)

## 2.0-beta7 - 2022-01-19

### Fixed

- When translating an attribute, if we can't find a translation, we default to whatever the FieldType gives back instead of erroring.
- `TranslatedText` fieldtype now implements `JsonSerializable` interface ([#50](https://github.com/getcandy/getcandy/issues/50)).
- Core tests now use the correct `User` model stub when running. By [@joelwmale](https://github.com/joelwmale)
- When creating a product, prices were being added twice. This should be resolved.
- When adding a cart line, meta fields were causing lines to be duplicated, this should be resolved.

### Changed

- Models that have channels now implement `start_at` and `end_at` columns. This replaces the previous `published_at` column.
- Laravel UI modal components removed.
- Description attribute is no longer `required` or a `system` attribute on install.

### Added

- Added a new `default` column to the `tax_classes` table.
- Added `customer_id` to orders so an order has a 1:1 relation to a customer. ([#73](https://github.com/getcandy/getcandy/issues/73)).
- Created the `AttributeManifest` class so dev's can add their own attributable classes.
- Created the `FieldTypeManifest` class so dev's can add custom FieldTypes to the store.
- Added `$table->userForeignKey()` macro for migrations that create foreign keys which reference a user id.

[View Changes](https://github.com/getcandy/core/compare/2.0-beta5...2.0-beta7)

## 2.0-beta5 - 2022-01-10

### Fixed

- Added check on customers for when using MySQL search driver to prevent undefined columns [#40](https://github.com/getcandy/getcandy/issues/40).

### Changed

- Changed `https` to `http` on country import due to issues with local environment CA installations.

## 2.0-beta4 - 2022-01-07

### Fixed

- Fixes [Issue 24](https://github.com/getcandy/getcandy/issues/24) where URL relationship is `elements` when it should be `element`.
- Fixed an issue where `now()->year` would return an int on single digit months, but we need to have a leading zero.

### Changed

- Customers `meta` column now uses Laravel's `casts` property and is cast to an object.

### Added

- Made customers searchable via Scout.
- Added addresses relationship to the customer model.

[View Changes](https://github.com/getcandy/core/compare/2.0-beta3...2.0-beta4)

## 2.0-beta3 - 2021-12-24

### Fixed

- Fixed and issue where the meilisearch set up wasn't creating the indexes it needed if they didn't exist.

[View Changes](https://github.com/getcandy/core/compare/2.0-beta2...2.0-beta3)

## 2.0-beta2 - 2021-12-23

### Fixed
- Default currency has `enabled` set to true.

### Changed
- Install command no longer publishes hub assets

### Added
- Added a default `CollectionGroup`.

[View Changes](https://github.com/getcandy/core/compare/2.0-beta...2.0-beta2)

## 2.0-beta - 2021-12-22

Initial release.
