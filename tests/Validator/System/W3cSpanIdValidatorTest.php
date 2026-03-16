<?php

namespace Tests\Validator\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\System\W3cSpanIdValidator;

/**
 * @internal
 */
class W3cSpanIdValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new W3cSpanIdValidator();

        $this->assertTrue($validator->validate('00f067aa0ba902b7'));
    }

    public function testRejectsAllZeroValue(): void
    {
        $validator = new W3cSpanIdValidator();

        $this->assertFalse($validator->validate(str_repeat('0', 16)));
    }

    public function testRejectsWrongLength(): void
    {
        $validator = new W3cSpanIdValidator();

        $this->assertFalse($validator->validate('00f067aa0ba902b'));
        $this->assertFalse($validator->validate('00f067aa0ba902b700'));
    }

    public function testRejectsInvalidCharacters(): void
    {
        $validator = new W3cSpanIdValidator();

        $this->assertFalse($validator->validate('00f067aa0ba902bg'));
    }

    public function testAcceptsUppercaseHex(): void
    {
        $validator = new W3cSpanIdValidator();

        $this->assertTrue($validator->validate('00F067AA0BA902B7'));
    }
}
