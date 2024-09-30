<?php
declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->ignoreDotFiles(false)
    ->ignoreVCSIgnored(true)
    ->in(['src', 'tests']);

$config = new PhpCsFixer\Config();
$config->setRiskyAllowed(true)
    ->setRules(['@PSR2' => true])
    ->setFinder($finder);

return $config;
