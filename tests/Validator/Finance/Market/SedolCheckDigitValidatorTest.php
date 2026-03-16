<?php

namespace Tests\Validator\Finance\Market;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Market\SedolCheckDigitValidator;

/**
 * @internal
 */
class SedolCheckDigitValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new SedolCheckDigitValidator();

        $this->assertTrue($validator->validate('0263494'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new SedolCheckDigitValidator();

        $this->assertFalse($validator->validate('0263495'));
    }

    public function testRejectsWrongLength(): void
    {
        $validator = new SedolCheckDigitValidator();

        $this->assertFalse($validator->validate('026349'));
        $this->assertFalse($validator->validate('02634940'));
    }

    public function testRejectsDisallowedLetters(): void
    {
        $validator = new SedolCheckDigitValidator();

        $this->assertFalse($validator->validate('A263494'));
    }

    public function testAcceptsUppercaseInput(): void
    {
        $validator = new SedolCheckDigitValidator();

        $this->assertTrue($validator->validate('B0YBKJ7'));
    }
}
