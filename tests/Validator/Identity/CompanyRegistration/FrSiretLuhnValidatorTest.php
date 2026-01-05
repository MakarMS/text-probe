<?php

namespace Tests\Validator\Identity\CompanyRegistration;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\CompanyRegistration\FrSiretLuhnValidator;

/**
 * @internal
 */
class FrSiretLuhnValidatorTest extends TestCase
{
    public function testAcceptsValidValue1(): void
    {
        $validator = new FrSiretLuhnValidator();

        $this->assertTrue($validator->validate('73282932000017'));
    }

    public function testAcceptsValidValue2(): void
    {
        $validator = new FrSiretLuhnValidator();

        $this->assertTrue($validator->validate('55210055400013'));
    }

    public function testAcceptsValidValue3(): void
    {
        $validator = new FrSiretLuhnValidator();

        $this->assertTrue($validator->validate('12345678901237'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new FrSiretLuhnValidator();

        $this->assertFalse($validator->validate('73282932000018'));
    }

    public function testRejectsShortValue(): void
    {
        $validator = new FrSiretLuhnValidator();

        $this->assertFalse($validator->validate('7328293200001'));
    }

    public function testRejectsLongValue(): void
    {
        $validator = new FrSiretLuhnValidator();

        $this->assertFalse($validator->validate('732829320000170'));
    }

    public function testRejectsNonDigit(): void
    {
        $validator = new FrSiretLuhnValidator();

        $this->assertFalse($validator->validate('7328293200001A'));
    }

    public function testRejectsWhitespace(): void
    {
        $validator = new FrSiretLuhnValidator();

        $this->assertFalse($validator->validate('73282932000017 '));
    }

    public function testRejectsSymbols(): void
    {
        $validator = new FrSiretLuhnValidator();

        $this->assertFalse($validator->validate('732-829-320-00017'));
    }

    public function testRejectsEmpty(): void
    {
        $validator = new FrSiretLuhnValidator();

        $this->assertFalse($validator->validate(''));
    }
}
