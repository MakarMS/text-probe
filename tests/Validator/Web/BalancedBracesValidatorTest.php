<?php

namespace Tests\Validator\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Web\BalancedBracesValidator;

/**
 * @internal
 */
class BalancedBracesValidatorTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testValidatesBalance(string $value, bool $expected): void
    {
        $validator = new BalancedBracesValidator();

        $this->assertSame($expected, $validator->validate($value));
    }

    public static function samples(): array
    {
        return [
            ['{}', true],
            ['{field}', true],
            ['{a { b }}', true],
            ['{a { b { c } }}', true],
            ['{items { edges { node { id } } }}', true],
            ['{', false],
            ['}', false],
            ['{a { b }', false],
            ['{a } }', false],
            ['{a { b }} }', false],
        ];
    }
}
