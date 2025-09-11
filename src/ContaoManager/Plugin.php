<?php
namespace Lukasbableck\ContaoPackagistInfoBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Lukasbableck\ContaoPackagistInfoBundle\ContaoPackagistInfoBundle;

class Plugin implements BundlePluginInterface {
    public function getBundles(ParserInterface $parser): array {
        return [BundleConfig::create(ContaoPackagistInfoBundle::class)->setLoadAfter([ContaoCoreBundle::class])];
    }
}
