<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\MtVatChecksumValidator;

/**
 * @internal
 */
class MtVatChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new MtVatChecksumValidator();

        $this->assertTrue($validator->validate('MT16545205'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new MtVatChecksumValidator();

        $this->assertTrue($validator->validate('MT58130128'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new MtVatChecksumValidator();

        $this->assertFalse($validator->validate('MT16545200'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new MtVatChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
