<?php

namespace Tests\Validator\Identity\TaxNumber;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\TaxNumber\DeSteuerIdChecksumValidator;

/**
 * @internal
 */
class DeSteuerIdChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue1(): void
    {
        $validator = new DeSteuerIdChecksumValidator();

        $this->assertTrue($validator->validate('12345678903'));
    }

    public function testAcceptsValidValue2(): void
    {
        $validator = new DeSteuerIdChecksumValidator();

        $this->assertTrue($validator->validate('52419630785'));
    }

    public function testAcceptsValidValue3(): void
    {
        $validator = new DeSteuerIdChecksumValidator();

        $this->assertTrue($validator->validate('11111111119'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new DeSteuerIdChecksumValidator();

        $this->assertFalse($validator->validate('12345678904'));
    }

    public function testRejectsShortValue(): void
    {
        $validator = new DeSteuerIdChecksumValidator();

        $this->assertFalse($validator->validate('1234567890'));
    }

    public function testRejectsLongValue(): void
    {
        $validator = new DeSteuerIdChecksumValidator();

        $this->assertFalse($validator->validate('123456789031'));
    }

    public function testRejectsNonDigit(): void
    {
        $validator = new DeSteuerIdChecksumValidator();

        $this->assertFalse($validator->validate('1234567890A'));
    }

    public function testRejectsEmpty(): void
    {
        $validator = new DeSteuerIdChecksumValidator();

        $this->assertFalse($validator->validate(''));
    }

    public function testRejectsWhitespace(): void
    {
        $validator = new DeSteuerIdChecksumValidator();

        $this->assertFalse($validator->validate('12345678903 '));
    }

    public function testRejectsSymbols(): void
    {
        $validator = new DeSteuerIdChecksumValidator();

        $this->assertFalse($validator->validate('12345-678903'));
    }
}
