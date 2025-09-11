<?php

use Lukasbableck\ContaoPackagistInfoBundle\Controller\ContentElement\PackagistInfoController;

$GLOBALS['TL_DCA']['tl_content']['palettes'][PackagistInfoController::TYPE] = '{type_legend},type,headline;{packagist_legend},packagistPackage;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{publish_legend},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['fields']['packagistPackage'] = [
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 255,
        'tl_class' => 'w50 clr',
    ],
    'sql' => "varchar(255) NOT NULL default ''",
];
