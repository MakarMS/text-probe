<?php

namespace Tests\Validator\Identity\TaxNumber;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\TaxNumber\PlPeselChecksumValidator;

/**
 * @internal
 */
class PlPeselChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue1(): void
    {
        $validator = new PlPeselChecksumValidator();

        $this->assertTrue($validator->validate('44051401359'));
    }

    public function testAcceptsValidValue2(): void
    {
        $validator = new PlPeselChecksumValidator();

        $this->assertTrue($validator->validate('02211301453'));
    }

    public function testAcceptsValidValue3(): void
    {
        $validator = new PlPeselChecksumValidator();

        $this->assertTrue($validator->validate('83010412342'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new PlPeselChecksumValidator();

        $this->assertFalse($validator->validate('44051401358'));
    }

    public function testRejectsShortValue(): void
    {
        $validator = new PlPeselChecksumValidator();

        $this->assertFalse($validator->validate('4405140135'));
    }

    public function testRejectsLongValue(): void
    {
        $validator = new PlPeselChecksumValidator();

        $this->assertFalse($validator->validate('440514013590'));
    }

    public function testRejectsNonDigit(): void
    {
        $validator = new PlPeselChecksumValidator();

        $this->assertFalse($validator->validate('4405140135A'));
    }

    public function testRejectsWhitespace(): void
    {
        $validator = new PlPeselChecksumValidator();

        $this->assertFalse($validator->validate('44051401359 '));
    }

    public function testRejectsSymbols(): void
    {
        $validator = new PlPeselChecksumValidator();

        $this->assertFalse($validator->validate('440-514-01359'));
    }

    public function testRejectsEmpty(): void
    {
        $validator = new PlPeselChecksumValidator();

        $this->assertFalse($validator->validate(''));
    }
}
