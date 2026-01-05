<?php

namespace Tests\Validator\Identity\TaxNumber;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\TaxNumber\SePersonnummerLuhnValidator;

/**
 * @internal
 */
class SePersonnummerLuhnValidatorTest extends TestCase
{
    public function testAcceptsValidValue1(): void
    {
        $validator = new SePersonnummerLuhnValidator();

        $this->assertTrue($validator->validate('6408231238'));
    }

    public function testAcceptsValidValue2(): void
    {
        $validator = new SePersonnummerLuhnValidator();

        $this->assertTrue($validator->validate('9912311124'));
    }

    public function testAcceptsValidValue3(): void
    {
        $validator = new SePersonnummerLuhnValidator();

        $this->assertTrue($validator->validate('8507099805'));
    }

    public function testAcceptsValidValue4(): void
    {
        $validator = new SePersonnummerLuhnValidator();

        $this->assertTrue($validator->validate('196408231238'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new SePersonnummerLuhnValidator();

        $this->assertFalse($validator->validate('6408231237'));
    }

    public function testRejectsShortValue(): void
    {
        $validator = new SePersonnummerLuhnValidator();

        $this->assertFalse($validator->validate('123456789'));
    }

    public function testRejectsLongValue(): void
    {
        $validator = new SePersonnummerLuhnValidator();

        $this->assertFalse($validator->validate('19123111240'));
    }

    public function testRejectsNonDigit(): void
    {
        $validator = new SePersonnummerLuhnValidator();

        $this->assertFalse($validator->validate('640823123A'));
    }

    public function testRejectsEmpty(): void
    {
        $validator = new SePersonnummerLuhnValidator();

        $this->assertFalse($validator->validate(''));
    }

    public function testRejectsSymbols(): void
    {
        $validator = new SePersonnummerLuhnValidator();

        $this->assertFalse($validator->validate('64-0823-1238'));
    }
}
