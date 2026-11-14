<?php

use PhpCsFixer\{
    Config,
    Finder
};

$finder = Finder::create()
    ->in(__DIR__ . '/app')
    ->in(__DIR__ . '/tests')
    ->exclude('vendor');

return new Config()
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'no_unused_imports' => true,
        'trailing_comma_in_multiline' => true,
        'phpdoc_scalar' => true,
        'unary_operator_spaces' => true,
        'binary_operator_spaces' => true,
        'blank_line_before_statement' => [
            'statements' => ['return'],
        ],
        'single_quote' => true,
        'no_extra_blank_lines' => true,
    ])
    ->setFinder($finder);
