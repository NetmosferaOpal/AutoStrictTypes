<?php declare(strict_types = 1);

namespace Netmosfera\OpalAutoStrictTypes;

use Netmosfera\Opal\Package;
use Netmosfera\Opal\PackageComponent;
use Netmosfera\Opal\PerPackagePreprocessorManager;
use function Netmosfera\Opal\Opal;

/**
 * Adds `declare(strict_types = 1)` on a per-package basis.
 */
function addStrictTypesToPackage(Package $package){
    // @codeCoverageIgnoreStart

    static $manager;

    $manager = $manager ?? new PerPackagePreprocessorManager(
        function(PackageComponent $packageComponent, Array $nodes): array{
            return addStrictTypesToPHPFileNodes($nodes);
        }
    );

    $manager->enablePreprocessorForPackage($package);

    Opal()->addPreprocessor($manager->filteringPreprocessor());

    // @codeCoverageIgnoreEnd
}
