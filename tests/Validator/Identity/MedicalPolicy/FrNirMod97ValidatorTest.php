<?php

namespace Tests\Validator\Identity\MedicalPolicy;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\MedicalPolicy\FrNirMod97Validator;

/**
 * @internal
 */
class FrNirMod97ValidatorTest extends TestCase
{
    public function testAcceptsValidValue1(): void
    {
        $validator = new FrNirMod97Validator();

        $this->assertTrue($validator->validate('1234567890123'));
    }

    public function testAcceptsValidValue2(): void
    {
        $validator = new FrNirMod97Validator();

        $this->assertTrue($validator->validate('9876543210987'));
    }

    public function testAcceptsValidValue3(): void
    {
        $validator = new FrNirMod97Validator();

        $this->assertTrue($validator->validate('0000000000000'));
    }

    public function testRejectsShortValue(): void
    {
        $validator = new FrNirMod97Validator();

        $this->assertFalse($validator->validate('123456789012'));
    }

    public function testRejectsLongValue(): void
    {
        $validator = new FrNirMod97Validator();

        $this->assertFalse($validator->validate('12345678901234'));
    }

    public function testRejectsNonDigit(): void
    {
        $validator = new FrNirMod97Validator();

        $this->assertFalse($validator->validate('123456789012A'));
    }

    public function testRejectsWhitespace(): void
    {
        $validator = new FrNirMod97Validator();

        $this->assertFalse($validator->validate('1234567890123 '));
    }

    public function testRejectsSymbols(): void
    {
        $validator = new FrNirMod97Validator();

        $this->assertFalse($validator->validate('123-456-789-0123'));
    }

    public function testRejectsEmpty(): void
    {
        $validator = new FrNirMod97Validator();

        $this->assertFalse($validator->validate(''));
    }

    public function testRejectsAlphaOnly(): void
    {
        $validator = new FrNirMod97Validator();

        $this->assertFalse($validator->validate('ABCDEFGHIJKLM'));
    }
}
