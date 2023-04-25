# Change Log for OXID eShop Codeception Modules

All notable changes to this project will be documented in this file.
The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [v1.1.0] - 2023-04-25

### Added
- mySQL 8 support

## [v1.0.0] - 2023-03-05

# [O3-Shop]

> All changes from this moment on will be published as O3-Shop.
> Earlier code components were created by OXID eSales AG and published under the GNU General Public License v3.0.

> The version number is reset to 1.0.0. All references to version numbers refer to the new versioning.

* * * * * * * * * *

## [1.6.0] - 2021-07-06

### Added
- Support array as translation directories list

### Changed
- InvalidResourceException is thrown if not existing translations directory is listed

## [1.5.0] - 2021-03-25

### Added
- Support of codeception v4

## [1.4.0] - 2020-11-10

### Added
- Add `shopId` parameter to `updateConfigInDatabase` method
- Add `updateConfigInDatabaseForShops` method as alias for multiple shop calls of `updateConfigInDatabase`
- Method:
    - `OxidEsales\Codeception\Module\OxideshopModules::uninstallModule`
    - `OxidEsales\Codeception\Module\Database::grabConfigValueFromDatabase`
    - `OxidEsales\Codeception\Module\Oxideshop::regenerateDatabaseViews`

## [1.3.0] - 2020-07-06

### Added
- Flow theme module
- Methods:
    - `Module\Oxideshop::seeAndClick`

### Deprecated
- Activate modules within oxideshop

## [1.2.0] - 2020-01-02

### Added
- Use declare(strict_types=1); in template files
- Screen shot url for failing tests

### Fix
- Fix bootstrap's template configuration with ^3.1 codeception version

## [1.1.0] -  2019-11-07

### Added
- Template for module tests initialization is added
- OxideshopAdmin module with admin frames selection actions
- OxideshopModules module with just the OXID module activation

### Fix
- Improved the waitForAjax method jQuery waiting condition to work with shortened and full jQuery calls

## [1.0.0] -  2019-07-26

### Added
- First version of the module introduced

[v1.1.0]: https://gitlab.o3-shop.com/o3/codeception-modules/-/compare/v1.0.0...v1.1.0
[v1.0.0]: https://gitlab.o3-shop.com/o3/codeception-modules/-/tags/v1.0.0
[O3-Shop]: https://www.o3-shop.com/
[1.6.0]: https://github.com/OXID-eSales/codeception-modules/compare/v1.5.0...v1.6.0
[1.5.0]: https://github.com/OXID-eSales/codeception-modules/compare/v1.4.0...v1.5.0
[1.4.0]: https://github.com/OXID-eSales/codeception-modules/compare/v1.3.0...v1.4.0
[1.3.0]: https://github.com/OXID-eSales/codeception-modules/compare/v1.2.0...v1.3.0
[1.2.0]: https://github.com/OXID-eSales/codeception-modules/compare/v1.1.0...v1.2.0
[1.1.0]: https://github.com/OXID-eSales/codeception-modules/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/OXID-eSales/codeception-modules/compare/78f569ceafc73440b800553c2f78885292aeccf8..v1.0.0
