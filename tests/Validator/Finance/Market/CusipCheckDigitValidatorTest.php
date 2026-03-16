<?php

namespace Tests\Validator\Finance\Market;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Market\CusipCheckDigitValidator;

/**
 * @internal
 */
class CusipCheckDigitValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new CusipCheckDigitValidator();

        $this->assertTrue($validator->validate('037833100'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new CusipCheckDigitValidator();

        $this->assertFalse($validator->validate('037833101'));
    }

    public function testRejectsWrongLength(): void
    {
        $validator = new CusipCheckDigitValidator();

        $this->assertFalse($validator->validate('03783310'));
        $this->assertFalse($validator->validate('0378331000'));
    }

    public function testRejectsInvalidCharacters(): void
    {
        $validator = new CusipCheckDigitValidator();

        $this->assertFalse($validator->validate('03783310!'));
    }

    public function testAcceptsUppercaseAlphaNumericPayload(): void
    {
        $validator = new CusipCheckDigitValidator();

        $this->assertTrue($validator->validate('594918104'));
    }
}
