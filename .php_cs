<?php
use Symfony\CS\Config\Config;
use Symfony\CS\Finder\DefaultFinder;
use Symfony\CS\Fixer\Contrib\HeaderCommentFixer;
use Symfony\CS\FixerInterface;

$finder = DefaultFinder::create()->in('app');

return Config::create()
             ->level(FixerInterface::SYMFONY_LEVEL)
             ->fixers([
                 '-yoda_conditions',
                 'align_double_arrow',
                 'align_equals',
                 'ereg_to_preg',
                 'header_comment',
                 'multiline_spaces_before_semicolon',
                 'no_blank_lines_before_namespace',
                 'ordered_use',
                 'phpdoc_order',
                 'phpdoc_var_to_type',
                 'short_array_syntax',
                 'strict',
                 'strict_param',
             ])
             ->setUsingCache(true)
             ->finder($finder);
