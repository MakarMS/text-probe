<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->exclude('vendor');

return (new Config())
    ->setRiskyAllowed(true)
    ->setCacheFile(__DIR__ . '/.php-cs-fixer.cache')
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setRules([
        /*
         |--------------------------------------------------------------------------
         | BASE RULESET
         |--------------------------------------------------------------------------
         */
        '@PSR12' => true,
        'strict_param' => true,

        /*
         |--------------------------------------------------------------------------
         | IMPORTS & NAMESPACES
         |--------------------------------------------------------------------------
         */
        'no_unused_imports' => true,
        'no_leading_namespace_whitespace' => true,
        'global_namespace_import' => [
            'import_classes' => true,
            'import_functions' => true,
            'import_constants' => true,
        ],
        'no_unneeded_import_alias' => true,
        'clean_namespace' => true,

        /*
         |--------------------------------------------------------------------------
         | CLASS & STRUCTURE
         |--------------------------------------------------------------------------
         */
        'class_attributes_separation' => [
            'elements' => [
                'method' => 'one',
                'property' => 'one',
                'trait_import' => 'one',
            ],
        ],
        'class_reference_name_casing' => true,
        'attribute_empty_parentheses' => [
            'use_parentheses' => false,
        ],
        'ordered_attributes' => true,
        'no_null_property_initialization' => true,

        /*
         |--------------------------------------------------------------------------
         | ARRAYS & PARAMETERS
         |--------------------------------------------------------------------------
         */
        'array_syntax' => ['syntax' => 'short'],
        'trim_array_spaces' => true,
        'whitespace_after_comma_in_array' => true,
        'no_whitespace_before_comma_in_array' => true,
        'trailing_comma_in_multiline' => [
            'elements' => ['arrays', 'arguments', 'parameters'],
        ],
        'no_multiline_whitespace_around_double_arrow' => true,
        'normalize_index_brace' => true,
        'array_indentation' => true,
        'no_spaces_around_offset' => true,

        /*
         |--------------------------------------------------------------------------
         | OPERATORS & SPACES
         |--------------------------------------------------------------------------
         */
        'binary_operator_spaces' => ['default' => 'single_space'],
        'concat_space' => ['spacing' => 'one'],
        'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline'],
        'not_operator_with_space' => false,
        'logical_operators' => true,
        'no_unneeded_control_parentheses' => [
            'statements' => ['break', 'clone', 'continue', 'echo_print', 'others', 'return', 'switch_case', 'yield', 'yield_from',
            ],
        ],
        'cast_spaces' => ['space' => 'single'],
        'no_short_bool_cast' => true,
        'no_unset_cast' => true,
        'ordered_types' => ['null_adjustment' => 'always_last', 'sort_algorithm' => 'none'],
        'nullable_type_declaration' => true,
        'type_declaration_spaces' => ['elements' => ['function', 'property']],
        'types_spaces' => true,

        /*
         |--------------------------------------------------------------------------
         | STRINGS & QUOTES
         |--------------------------------------------------------------------------
         */
        'single_quote' => true,
        'no_empty_comment' => true,
        'single_line_comment_spacing' => true,
        'single_line_comment_style' => ['comment_types' => ['hash']],
        'no_binary_string' => true,
        'simple_to_complex_string_variable' => true,

        /*
         |--------------------------------------------------------------------------
         | WHITESPACE & BLANK LINES
         |--------------------------------------------------------------------------
         */
        'no_trailing_whitespace_in_comment' => true,
        'no_empty_statement' => true,
        'no_extra_blank_lines' => [
            'tokens' => [
                'attribute',
                'case',
                'continue',
                'curly_brace_block',
                'default', 'extra',
                'parenthesis_brace_block',
                'square_brace_block',
                'switch',
                'throw',
                'use',
            ],
        ],
        'blank_line_before_statement' => ['statements' => ['return', 'if']],
        'method_chaining_indentation' => true,
        'statement_indentation' => ['stick_comment_to_next_continuous_control_statement' => true],

        /*
         |--------------------------------------------------------------------------
         | CODE QUALITY / SIMPLIFICATION
         |--------------------------------------------------------------------------
         */
        'no_useless_return' => true,
        'simplified_if_return' => true,
        'yoda_style' => [
            'equal' => false,
            'identical' => false,
            'less_and_greater' => false,
        ],
        'no_alias_language_construct_call' => true,
        'empty_loop_body' => ['style' => 'braces'],
        'empty_loop_condition' => true,
        'include' => true,
        'no_alternative_syntax' => false,
        'no_unneeded_braces' => ['namespaces' => true],
        'no_useless_else' => true,
        'lambda_not_used_import' => true,
        'nullable_type_declaration_for_default_null_value' => true,
        'single_line_throw' => true,
        'fully_qualified_strict_types' => true,
        'combine_consecutive_issets' => true,
        'no_useless_concat_operator' => true,
        'no_useless_nullsafe_operator' => true,
        'object_operator_without_whitespace' => true,
        'standardize_increment' => true,
        'standardize_not_equals' => true,
        'echo_tag_syntax' => ['format' => 'short'],
        'linebreak_after_opening_tag' => true,
        'return_assignment' => true,
        'multiline_whitespace_before_semicolons' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'semicolon_after_instruction' => true,
        'space_after_semicolon' => ['remove_in_empty_for_expressions' => true],

        /*
         |--------------------------------------------------------------------------
         | PHPUnit
         |--------------------------------------------------------------------------
         */
        'php_unit_attributes' => true,
        'php_unit_data_provider_method_order' => true,
        'php_unit_fqcn_annotation' => true,
        'php_unit_internal_class' => true,
        'php_unit_method_casing' => true,

        /*
         |--------------------------------------------------------------------------
         | PHPDOC
         |--------------------------------------------------------------------------
         */
        'phpdoc_order' => ['order' => ['param', 'return', 'throws']],
        'phpdoc_align' => ['align' => 'vertical'],
        'phpdoc_no_alias_tag' => [
            'replacements' => ['const' => 'var', 'link' => 'see', 'property-read' => 'property', 'property-write' => 'property', 'type' => 'var'],
        ],
        'align_multiline_comment' => true,
        'general_phpdoc_tag_rename' => ['replacements' => ['inheritDocs' => 'inheritDoc']],
        'no_blank_lines_after_phpdoc' => true,
        'no_empty_phpdoc' => true,
        'no_superfluous_phpdoc_tags' => ['allow_hidden_params' => true, 'remove_inheritdoc' => true],
        'phpdoc_annotation_without_dot' => true,
        'phpdoc_indent' => true,
        'phpdoc_inline_tag_normalizer' => true,
        'phpdoc_no_access' => true,
        'phpdoc_no_package' => true,
        'phpdoc_no_useless_inheritdoc' => true,
        'phpdoc_param_order' => true,
        'phpdoc_return_self_reference' => true,
        'phpdoc_scalar' => true,
        'phpdoc_separation' => [
            'groups' => [
                ['Annotation', 'NamedArgumentConstructor', 'Target'],
                ['author', 'copyright', 'license'],
                ['category', 'package', 'subpackage'],
                ['property', 'property-read', 'property-write'],
                ['deprecated', 'link', 'see', 'since']],
            'skip_unlisted_annotations' => false,
        ],
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_summary' => true,
        'phpdoc_tag_casing' => true,
        'phpdoc_tag_type' => ['tags' => ['inheritDoc' => 'inline']],
        'phpdoc_to_comment' => false,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'phpdoc_trim' => true,
        'phpdoc_types' => true,
        'phpdoc_types_order' => ['null_adjustment' => 'always_last', 'sort_algorithm' => 'none'],
        'phpdoc_var_annotation_correct_order' => true,
        'phpdoc_var_without_name' => true,
    ])
    ->setFinder($finder);
