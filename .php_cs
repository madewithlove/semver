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
                 'align_double_arrow' => false,
                 'align_equals' => false,
                 'concat_with_spaces' => false,
                 'ereg_to_preg' => true,
                 'header_comment' => false,
                 'linebreak_after_opening_tag' => true,
                 'long_array_syntax' => false,
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
                 'phpdoc_property' => true,
                 'phpdoc_var_to_type' => false,
                 'psr0' => true,
                 'short_array_syntax' => true,
                 'strict_comparison' => true,
                 'strict_param' => true,
             ])
             ->finder($finder);
