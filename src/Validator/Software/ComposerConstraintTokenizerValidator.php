<?php

namespace TextProbe\Validator\Software;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for Composer version constraint strings using tokenization.
 *
 * Ensures the input contains only allowed tokens:
 * - operators (^, ~, >=, <=, >, <, =)
 * - wildcard (*)
 * - logical OR (||)
 * - separators (comma)
 * - whitespace
 * - versions in v?MAJOR.MINOR.PATCH with optional pre-release/build suffixes
 */
class ComposerConstraintTokenizerValidator implements IValidator
{
    #[\Override]
    public function validate(string $raw): bool
    {
        $input = trim($raw);

        if ($input === '') {
            return false;
        }

        $patterns = [
            '/\G\s+/A',
            '/\G\|\|/A',
            '/\G>=/A',
            '/\G<=/A',
            '/\G>/A',
            '/\G</A',
            '/\G=/A',
            '/\G\^/A',
            '/\G~/A',
            '/\G\*/A',
            '/\G,/A',
            '/\Gv?\d+\.\d+\.\d+(?:-[0-9A-Za-z.-]+)?(?:\+[0-9A-Za-z.-]+)?/A',
        ];

        $offset = 0;
        $length = strlen($input);

        while ($offset < $length) {
            $matched = false;

            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $input, $matches, 0, $offset) === 1) {
                    $offset += strlen($matches[0]);
                    $matched = true;
                    break;
                }
            }

            if (!$matched) {
                return false;
            }
        }

        return true;
    }
}
