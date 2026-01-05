<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\RoVatChecksumValidator;

/**
 * @internal
 */
class RoVatChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new RoVatChecksumValidator();

        $this->assertTrue($validator->validate('RO76503380'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new RoVatChecksumValidator();

        $this->assertTrue($validator->validate('RO7899630'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new RoVatChecksumValidator();

        $this->assertFalse($validator->validate('RO76503381'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new RoVatChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
