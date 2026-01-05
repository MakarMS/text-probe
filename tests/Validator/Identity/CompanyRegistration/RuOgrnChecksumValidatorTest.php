<?php

namespace Tests\Validator\Identity\CompanyRegistration;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\CompanyRegistration\RuOgrnChecksumValidator;

/**
 * @internal
 */
class RuOgrnChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue1(): void
    {
        $validator = new RuOgrnChecksumValidator();

        $this->assertTrue($validator->validate('1027700132195'));
    }

    public function testAcceptsValidValue2(): void
    {
        $validator = new RuOgrnChecksumValidator();

        $this->assertTrue($validator->validate('1057746719106'));
    }

    public function testAcceptsValidValue3(): void
    {
        $validator = new RuOgrnChecksumValidator();

        $this->assertTrue($validator->validate('1111111111110'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new RuOgrnChecksumValidator();

        $this->assertFalse($validator->validate('1027700132194'));
    }

    public function testRejectsShortValue(): void
    {
        $validator = new RuOgrnChecksumValidator();

        $this->assertFalse($validator->validate('102770013219'));
    }

    public function testRejectsLongValue(): void
    {
        $validator = new RuOgrnChecksumValidator();

        $this->assertFalse($validator->validate('10277001321950'));
    }

    public function testRejectsNonDigit(): void
    {
        $validator = new RuOgrnChecksumValidator();

        $this->assertFalse($validator->validate('102770013219A'));
    }

    public function testRejectsWhitespace(): void
    {
        $validator = new RuOgrnChecksumValidator();

        $this->assertFalse($validator->validate('1027700132195 '));
    }

    public function testRejectsSymbols(): void
    {
        $validator = new RuOgrnChecksumValidator();

        $this->assertFalse($validator->validate('102-770-013-2195'));
    }

    public function testRejectsEmpty(): void
    {
        $validator = new RuOgrnChecksumValidator();

        $this->assertFalse($validator->validate(''));
    }
}
