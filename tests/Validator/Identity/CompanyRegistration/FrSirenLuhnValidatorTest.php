<?php

namespace Tests\Validator\Identity\CompanyRegistration;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\CompanyRegistration\FrSirenLuhnValidator;

/**
 * @internal
 */
class FrSirenLuhnValidatorTest extends TestCase
{
    public function testAcceptsValidValue1(): void
    {
        $validator = new FrSirenLuhnValidator();

        $this->assertTrue($validator->validate('732829320'));
    }

    public function testAcceptsValidValue2(): void
    {
        $validator = new FrSirenLuhnValidator();

        $this->assertTrue($validator->validate('552100554'));
    }

    public function testAcceptsValidValue3(): void
    {
        $validator = new FrSirenLuhnValidator();

        $this->assertTrue($validator->validate('123456782'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new FrSirenLuhnValidator();

        $this->assertFalse($validator->validate('732829321'));
    }

    public function testRejectsShortValue(): void
    {
        $validator = new FrSirenLuhnValidator();

        $this->assertFalse($validator->validate('73282932'));
    }

    public function testRejectsLongValue(): void
    {
        $validator = new FrSirenLuhnValidator();

        $this->assertFalse($validator->validate('7328293200'));
    }

    public function testRejectsNonDigit(): void
    {
        $validator = new FrSirenLuhnValidator();

        $this->assertFalse($validator->validate('73282932A'));
    }

    public function testRejectsWhitespace(): void
    {
        $validator = new FrSirenLuhnValidator();

        $this->assertFalse($validator->validate('732829320 '));
    }

    public function testRejectsSymbols(): void
    {
        $validator = new FrSirenLuhnValidator();

        $this->assertFalse($validator->validate('732-829-320'));
    }

    public function testRejectsEmpty(): void
    {
        $validator = new FrSirenLuhnValidator();

        $this->assertFalse($validator->validate(''));
    }
}
