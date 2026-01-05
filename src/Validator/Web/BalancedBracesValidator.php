<?php

namespace TextProbe\Validator\Web;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validates that curly braces are balanced and properly nested.
 */
class BalancedBracesValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $balance = 0;
        $length = strlen($raw);

        for ($i = 0; $i < $length; $i++) {
            $char = $raw[$i];

            if ($char === '{') {
                $balance++;
                continue;
            }

            if ($char === '}') {
                $balance--;

                if ($balance < 0) {
                    return false;
                }
            }
        }

        return $balance === 0;
    }
}
