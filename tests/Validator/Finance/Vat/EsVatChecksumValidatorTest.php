<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\EsVatChecksumValidator;

/**
 * @internal
 */
class EsVatChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new EsVatChecksumValidator();

        $this->assertTrue($validator->validate('ESF08109498'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new EsVatChecksumValidator();

        $this->assertTrue($validator->validate('ES77428706B'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new EsVatChecksumValidator();

        $this->assertFalse($validator->validate('ESF08109490'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new EsVatChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
