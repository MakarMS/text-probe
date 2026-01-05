<?php

namespace Tests\Validator\Software;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Software\ComposerConstraintTokenizerValidator;

/**
 * @internal
 */
class ComposerConstraintTokenizerValidatorTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validConstraintProvider')]
    public function testValidConstraints(string $constraint): void
    {
        $validator = new ComposerConstraintTokenizerValidator();

        $this->assertTrue($validator->validate($constraint));
    }

    /**
     * @return array<string, array{0: string}>
     */
    public static function validConstraintProvider(): array
    {
        return [
            'caret' => ['^1.2.3'],
            'tilde' => ['~1.2.3'],
            'gte' => ['>=1.2.3'],
            'lte' => ['<=1.2.3'],
            'gt' => ['>1.2.3'],
            'lt' => ['<1.2.3'],
            'eq' => ['=1.2.3'],
            'version' => ['1.2.3'],
            'v-prefix' => ['v1.2.3'],
            'prerelease-build' => ['1.2.3-alpha.1+build.5'],
            'or-constraint' => ['^1.2.3 || >=2.0.0'],
            'comma-separated' => ['>=1.2.3, <2.0.0'],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('invalidConstraintProvider')]
    public function testInvalidConstraints(string $constraint): void
    {
        $validator = new ComposerConstraintTokenizerValidator();

        $this->assertFalse($validator->validate($constraint));
    }

    /**
     * @return array<string, array{0: string}>
     */
    public static function invalidConstraintProvider(): array
    {
        return [
            'empty' => [''],
            'whitespace' => ['   '],
            'double-dot' => ['1..2.3'],
            'missing-patch' => ['1.2'],
            'bad-operator' => ['!1.2.3'],
            'wildcard-non-token' => ['1.2.*'],
            'invalid-delimiter' => ['1.2.3 ||| 2.0.0'],
            'letters' => ['version 1.2.3'],
            'prefix-suffix' => ['foo^1.2.3'],
            'comma-and-text' => ['1.2.3, next'],
            'invalid-pre' => ['1.2.3-$$$'],
            'invalid-build' => ['1.2.3+build$'],
        ];
    }
}
