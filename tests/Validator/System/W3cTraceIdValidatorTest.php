<?php

namespace Tests\Validator\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\System\W3cTraceIdValidator;

/**
 * @internal
 */
class W3cTraceIdValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new W3cTraceIdValidator();

        $this->assertTrue($validator->validate('4bf92f3577b34da6a3ce929d0e0e4736'));
    }

    public function testRejectsAllZeroValue(): void
    {
        $validator = new W3cTraceIdValidator();

        $this->assertFalse($validator->validate(str_repeat('0', 32)));
    }

    public function testRejectsWrongLength(): void
    {
        $validator = new W3cTraceIdValidator();

        $this->assertFalse($validator->validate('4bf92f3577b34da6a3ce929d0e0e473'));
        $this->assertFalse($validator->validate('4bf92f3577b34da6a3ce929d0e0e473611'));
    }

    public function testRejectsInvalidCharacters(): void
    {
        $validator = new W3cTraceIdValidator();

        $this->assertFalse($validator->validate('4bf92f3577b34da6a3ce929d0e0e473g'));
    }

    public function testAcceptsUppercaseHex(): void
    {
        $validator = new W3cTraceIdValidator();

        $this->assertTrue($validator->validate('4BF92F3577B34DA6A3CE929D0E0E4736'));
    }
}
