<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\GbVatChecksumValidator;

/**
 * @internal
 */
class GbVatChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new GbVatChecksumValidator();

        $this->assertTrue($validator->validate('GB565213451'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new GbVatChecksumValidator();

        $this->assertTrue($validator->validate('GB122424219'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new GbVatChecksumValidator();

        $this->assertFalse($validator->validate('GB565213450'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new GbVatChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
