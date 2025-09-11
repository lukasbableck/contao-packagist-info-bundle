<?php

$ruleset = new TwigCsFixer\Ruleset\Ruleset();

$ruleset->addStandard(new TwigCsFixer\Standard\TwigCsFixer());
$ruleset->addStandard(new TwigCsFixer\Standard\Symfony());

$ruleset->removeRule(TwigCsFixer\Rules\Variable\VariableNameRule::class);
$ruleset->removeRule(TwigCsFixer\Rules\Whitespace\EmptyLinesRule::class);
$ruleset->overrideRule(new TwigCsFixer\Rules\Whitespace\IndentRule(4, true));

$config = new TwigCsFixer\Config\Config();
$config->allowNonFixableRules();
$config->setRuleset($ruleset);

return $config;
