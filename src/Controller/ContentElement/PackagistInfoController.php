<?php
namespace Lukasbableck\ContaoPackagistInfoBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Lukasbableck\ContaoPackagistInfoBundle\Client\PackagistClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(self::TYPE, category: 'miscellaneous')]
class PackagistInfoController extends AbstractContentElementController {
    public const TYPE = 'packagist_info';

    public function __construct(private readonly PackagistClient $packagistClient) {
    }

    public function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response {
        $template->package = $this->packagistClient->getPackageData($model->packagistPackage ?? '');

        return $template->getResponse();
    }
}
