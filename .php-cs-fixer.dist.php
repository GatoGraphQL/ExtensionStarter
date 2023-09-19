<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/layers/GatoGraphQLForWP/packages/*/src',
        __DIR__ . '/layers/GatoGraphQLForWP/packages/*/tests',
        __DIR__ . '/layers/GatoGraphQLForWP/plugins/*/src',
        __DIR__ . '/layers/GatoGraphQLForWP/plugins/*/tests',
    ])
;

$config = new PhpCsFixer\Config();
return $config->setRules([
        'no_unused_imports' => true,
    ])
    ->setFinder($finder)
;
