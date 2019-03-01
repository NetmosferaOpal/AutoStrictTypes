[release]: https://img.shields.io/github/release/NetmosferaOpal/AutoStrictTypes.svg
[release-URL]: https://github.com/NetmosferaOpal/AutoStrictTypes/releases
[status]: https://travis-ci.org/NetmosferaOpal/AutoStrictTypes.svg?branch=master
[status-URL]: https://travis-ci.org/NetmosferaOpal/AutoStrictTypes
[coverage]: https://coveralls.io/repos/github/NetmosferaOpal/AutoStrictTypes/badge.svg?branch=master
[coverage-URL]: https://coveralls.io/github/NetmosferaOpal/AutoStrictTypes?branch=master

# Opal Auto-strict-types

[![][release]][release-URL]
[![][status]][status-URL]
[![][coverage]][coverage-URL]

Makes `strict_types` default to `1` rather than `0`, on a per-package basis.

## Installation in opal.php

```php
<?php declare(strict_types = 1);

use Netmosfera\Opal\Identifier;
use Netmosfera\Opal\Package;
use Netmosfera\Opal\PackagePath;
use Netmosfera\Opal\Path;
use function Netmosfera\Opal\Opal;
use function Netmosfera\OpalAutoStrictTypes\addStrictTypesToPackage;

(function(){
    $vendor  = new Identifier("WayneEnterprises");
    $name    = new Identifier("BatMobile");
    $package = new Package($vendor, $name);
    $path    = new Path(__DIR__ . "/src");
    
    Opal()->addPackage(new PackagePath($package, $path));

    if(!NETMOSFERA_OPAL_LOADER_STATIC){
        
        /* ... */
        
        addStrictTypesToPackage($package);
    }
})();
```
