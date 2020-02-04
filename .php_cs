<?php
use PhpCsFixer\Config;
use PhpCsFixer\Finder;

require 'vendor/autoload.php';

$finder = Finder::create()->in([
    'app',
    'tests',
]);

return Config::create()
             ->setRiskyAllowed(true)
             ->setRules([
                 '@Symfony' => true,
                 'binary_operator_spaces' => [
                    'align_double_arrow' => false,
                    'align_equals' => false,
                 ],
                 'concat_space' => false,
                 'ereg_to_preg' => true,
                 'header_comment' => false,
                 'linebreak_after_opening_tag' => true,
                 'array_syntax' => 'short_array',
                 'no_blank_lines_before_namespace' => false,
                 'no_multiline_whitespace_before_semicolons' => true,
                 'no_php4_constructor' => true,
                 'no_short_echo_tag' => true,
                 'no_useless_return' => true,
                 'not_operator_with_space' => false,
                 'not_operator_with_successor_space' => false,
                 'ordered_imports' => true,
                 'php_unit_construct' => true,
                 'php_unit_strict' => false,
                 'phpdoc_order' => true,
                 'psr0' => true,
                 'array_syntax' => [
                     'syntax' => 'short',
                 ],
                 'strict_comparison' => true,
                 'strict_param' => true,
             ])
             ->setFinder($finder);
