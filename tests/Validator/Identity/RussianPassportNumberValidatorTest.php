<?php

namespace Tests\Validator\Identity;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\RussianPassportNumberValidator;

/**
 * @internal
 */
class RussianPassportNumberValidatorTest extends TestCase
{
    public function testValidPassportWithSpaces(): void
    {
        $validator = new RussianPassportNumberValidator();

        $this->assertTrue($validator->validate('45 01 123456'));
    }

    public function testValidPassportWithHyphens(): void
    {
        $validator = new RussianPassportNumberValidator();

        $this->assertTrue($validator->validate('11-22-333444'));
    }

    public function testValidPassportWithoutSeparators(): void
    {
        $validator = new RussianPassportNumberValidator();

        $this->assertTrue($validator->validate('4501123456'));
    }

    public function testRejectsTooShort(): void
    {
        $validator = new RussianPassportNumberValidator();

        $this->assertFalse($validator->validate('45 01 12345'));
    }

    public function testRejectsTooLong(): void
    {
        $validator = new RussianPassportNumberValidator();

        $this->assertFalse($validator->validate('45 01 1234567'));
    }

    public function testRejectsRegion00(): void
    {
        $validator = new RussianPassportNumberValidator();

        $this->assertFalse($validator->validate('00 12 345678'));
    }

    public function testRejectsZeroSerialPart(): void
    {
        $validator = new RussianPassportNumberValidator();

        $this->assertFalse($validator->validate('45 01 000000'));
    }

    public function testRejectsWhenNoDigitsPresent(): void
    {
        $validator = new RussianPassportNumberValidator();

        $this->assertFalse($validator->validate('no passport here'));
    }

    public function testRejectsMixedNonDigitsThatDoNotProduceTenDigits(): void
    {
        $validator = new RussianPassportNumberValidator();

        $this->assertFalse($validator->validate('AA-45-01-12345-BB'));
    }
}
