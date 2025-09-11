<?php
namespace Lukasbableck\ContaoPackagistInfoBundle\InsertTag;

use Contao\CoreBundle\DependencyInjection\Attribute\AsInsertTag;
use Contao\CoreBundle\InsertTag\Exception\InvalidInsertTagException;
use Contao\CoreBundle\InsertTag\InsertTagResult;
use Contao\CoreBundle\InsertTag\OutputType;
use Contao\CoreBundle\InsertTag\ResolvedInsertTag;
use Lukasbableck\ContaoPackagistInfoBundle\Client\PackagistClient;

#[AsInsertTag('packagist')]
class PackagistInsertTag {
    public function __construct(private readonly PackagistClient $packagistClient) {
    }

    public function __invoke(ResolvedInsertTag $insertTag): InsertTagResult {
        if ($insertTag->getParameters()->get(0) === null || $insertTag->getParameters()->get(1) === null) {
            throw new InvalidInsertTagException('Missing parameters for insert tag.');
        }

        $package = $insertTag->getParameters()->get(0);
        $attribute = $insertTag->getParameters()->get(1);

        $packageData = $this->packagistClient->getPackageData($package);
        if (!$packageData) {
            throw new InvalidInsertTagException('Package not found on Packagist.');
        }

        $parameter = $packageData[$attribute] ?? null;
        if ($parameter === null) {
            throw new InvalidInsertTagException('Attribute not found in package data.');
        }

        if (\is_array($parameter) || \is_object($parameter)) {
            throw new InvalidInsertTagException('Attribute is not a scalar value.');
        }

        return new InsertTagResult($parameter, OutputType::text);
    }
}
