<?php

namespace Tests\Validator\Identity\TaxNumber;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\TaxNumber\PlNipChecksumValidator;

/**
 * @internal
 */
class PlNipChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue1(): void
    {
        $validator = new PlNipChecksumValidator();

        $this->assertTrue($validator->validate('1234563218'));
    }

    public function testAcceptsValidValue2(): void
    {
        $validator = new PlNipChecksumValidator();

        $this->assertTrue($validator->validate('8567346215'));
    }

    public function testAcceptsValidValue3(): void
    {
        $validator = new PlNipChecksumValidator();

        $this->assertTrue($validator->validate('1011001015'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new PlNipChecksumValidator();

        $this->assertFalse($validator->validate('1234563219'));
    }

    public function testRejectsShortValue(): void
    {
        $validator = new PlNipChecksumValidator();

        $this->assertFalse($validator->validate('123456321'));
    }

    public function testRejectsLongValue(): void
    {
        $validator = new PlNipChecksumValidator();

        $this->assertFalse($validator->validate('12345632180'));
    }

    public function testRejectsNonDigit(): void
    {
        $validator = new PlNipChecksumValidator();

        $this->assertFalse($validator->validate('123456321A'));
    }

    public function testRejectsWhitespace(): void
    {
        $validator = new PlNipChecksumValidator();

        $this->assertFalse($validator->validate('1234563218 '));
    }

    public function testRejectsSymbols(): void
    {
        $validator = new PlNipChecksumValidator();

        $this->assertFalse($validator->validate('123-456-3218'));
    }

    public function testRejectsEmpty(): void
    {
        $validator = new PlNipChecksumValidator();

        $this->assertFalse($validator->validate(''));
    }
}
