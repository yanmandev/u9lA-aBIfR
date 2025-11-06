<?php

declare(strict_types=1);

$finder = new PhpCsFixer\Finder();
$config = new PhpCsFixer\Config();

$config->setRiskyAllowed(true);

$finder
    ->in([
        __DIR__ . '/assets',
        __DIR__ . '/behaviors',
        __DIR__ . '/controllers',
        __DIR__ . '/bootstrap',
        __DIR__ . '/common',
        __DIR__ . '/forms',
        __DIR__ . '/helpers',
        __DIR__ . '/listeners',
    ])
    ->exclude([
        'migrations',
        'vendor',
        'web',
        'views',
    ])
    ->name('*.php')
    ->ignoreVCS(true)
    ->ignoreDotFiles(true);

$config->setRules([
    '@PSR2' => true,
    '@PHP74Migration' => true,
    'concat_space' => ['spacing' => 'one'],
    'native_function_invocation' => false,
    'single_blank_line_at_eof' => false,
    'no_extra_blank_lines' => ['tokens' => ['extra']],
    'blank_line_before_statement' => [
        'statements' => ['return'],
    ],
    'ordered_imports' => [
        'imports_order' => ['class', 'function', 'const'],
        'sort_algorithm' => 'alpha',
    ],
    'no_unused_imports' => true,
    'binary_operator_spaces' => [
        'default' => 'single_space',
    ],
]);

$config->setFinder($finder);

return $config;