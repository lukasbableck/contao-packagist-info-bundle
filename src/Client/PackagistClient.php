<?php
namespace Lukasbableck\ContaoPackagistInfoBundle\Client;

use Packagist\Api\Client;
use Packagist\Api\Result\Package;
use Packagist\Api\Result\Package\Version;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class PackagistClient {
    private AdapterInterface $packageCache;
    private Client $packagistClient;

    public function __construct() {
        $this->packageCache = new FilesystemAdapter();
        $this->packagistClient = new Client();
    }

    public function getPackageData(string $packageName) {
        $cacheKey = 'packagist_package_'.md5($packageName);
        $cacheItem = $this->packageCache->getItem($cacheKey);

        if (!$cacheItem->isHit() || (time() - $cacheItem->get()['updated']) > 600) {
            try {
                $packageData = $this->packagistClient->get($packageName);
                if ($packageData) {
                    $cacheItem->set([
                        'content' => $this->addPackageInformation($packageData),
                        'updated' => time(),
                    ]);
                    $this->packageCache->save($cacheItem);
                }
            } catch (\Exception $e) {
                if (!$cacheItem->isHit()) {
                    return null;
                }
            }
        }

        return $cacheItem->get()['content'] ?? null;
    }

    /* @var $packageData Package[] */
    private function addPackageInformation(Package $packageData) {
        $data = [];
        $data['name'] = $packageData->getName();
        $data['description'] = $packageData->getDescription();
        $data['lastUpdated'] = $packageData->getTime() ? new \DateTime($packageData->getTime()) : null;
        $data['versions'] = $packageData->getVersions();
        $data['latestStableVersion'] = $this->getLatestStableVersion($packageData);
        $data['repository'] = $packageData->getRepository();
        $data['downloads'] = $packageData->getDownloads();
        $data['totalDownloads'] = $packageData->getDownloads()->getTotal() ?? 0;
        $data['favers'] = $packageData->getFavers();
        $data['githubStars'] = $packageData->getGithubStars();
        $data['githubForks'] = $packageData->getGithubForks();
        $data['githubWatchers'] = $packageData->getGithubWatchers();
        $data['githubOpenIssues'] = $packageData->getGithubOpenIssues();
        $data['language'] = $packageData->getLanguage();

        return $data;
    }

    private function getLatestStableVersion(Package $packageData): ?Version {
        foreach ($packageData->getVersions() as $version) {
            if (preg_match('/^\d+\.\d+\.\d+$/', $version->getVersion())) {
                return $version;
            }
        }

        return null;
    }
}
