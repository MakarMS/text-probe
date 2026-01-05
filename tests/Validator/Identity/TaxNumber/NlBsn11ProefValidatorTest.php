<?php

namespace Tests\Validator\Identity\TaxNumber;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\TaxNumber\NlBsn11ProefValidator;

/**
 * @internal
 */
class NlBsn11ProefValidatorTest extends TestCase
{
    public function testAcceptsValidValue1(): void
    {
        $validator = new NlBsn11ProefValidator();

        $this->assertTrue($validator->validate('100000009'));
    }

    public function testAcceptsValidValue2(): void
    {
        $validator = new NlBsn11ProefValidator();

        $this->assertTrue($validator->validate('100000010'));
    }

    public function testAcceptsValidValue3(): void
    {
        $validator = new NlBsn11ProefValidator();

        $this->assertTrue($validator->validate('100000022'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new NlBsn11ProefValidator();

        $this->assertFalse($validator->validate('100000011'));
    }

    public function testRejectsShortValue(): void
    {
        $validator = new NlBsn11ProefValidator();

        $this->assertFalse($validator->validate('12345678'));
    }

    public function testRejectsLongValue(): void
    {
        $validator = new NlBsn11ProefValidator();

        $this->assertFalse($validator->validate('1234567890'));
    }

    public function testRejectsNonDigit(): void
    {
        $validator = new NlBsn11ProefValidator();

        $this->assertFalse($validator->validate('12345678A'));
    }

    public function testRejectsWhitespace(): void
    {
        $validator = new NlBsn11ProefValidator();

        $this->assertFalse($validator->validate('100000009 '));
    }

    public function testRejectsSymbols(): void
    {
        $validator = new NlBsn11ProefValidator();

        $this->assertFalse($validator->validate('100.000.009'));
    }

    public function testRejectsEmpty(): void
    {
        $validator = new NlBsn11ProefValidator();

        $this->assertFalse($validator->validate(''));
    }
}
