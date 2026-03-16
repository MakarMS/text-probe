<?php

namespace Tests\Validator\Identity;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\ImeiLuhnValidator;

/**
 * @internal
 */
class ImeiLuhnValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new ImeiLuhnValidator();

        $this->assertTrue($validator->validate('490154203237518'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new ImeiLuhnValidator();

        $this->assertFalse($validator->validate('490154203237519'));
    }

    public function testRejectsWrongLength(): void
    {
        $validator = new ImeiLuhnValidator();

        $this->assertFalse($validator->validate('49015420323751'));
        $this->assertFalse($validator->validate('4901542032375189'));
    }

    public function testRejectsNonDigitInput(): void
    {
        $validator = new ImeiLuhnValidator();

        $this->assertFalse($validator->validate('ABCDEFGHIJKLMNO'));
    }

    public function testAcceptsFormattedDigits(): void
    {
        $validator = new ImeiLuhnValidator();

        $this->assertTrue($validator->validate('49 015420 323751 8'));
    }
}
