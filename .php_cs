<?php
$rules = [
    '@Symfony' => true,
    'ordered_class_elements' => [
        'use_trait',
        'constant_public',
        'constant_protected',
        'constant_private',
        'property_public',
        'property_protected',
        'property_private',
        'construct',
        'phpunit',
        'method_public',
        'method_protected',
        'method_private',
        'destruct',
        'magic'
    ],
    'ordered_imports' => true,
    'phpdoc_add_missing_param_annotation' => true,
    'phpdoc_types_order' => ['null_adjustment' => 'always_last'],
    'single_line_comment_style' => ['comment_types' => ['hash']]
];
$excludes = [
    // add exclude project directory
    'vendor',
    'tests',
];

return PhpCsFixer\Config::create()
    ->setRules($rules)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude($excludes)
            ->in(__DIR__)
            ->notName('README.md')
            ->notName('*.xml')
            ->notName('*.yml')
    );
