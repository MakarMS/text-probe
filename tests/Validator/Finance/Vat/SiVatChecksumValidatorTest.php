<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\SiVatChecksumValidator;

/**
 * @internal
 */
class SiVatChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new SiVatChecksumValidator();

        $this->assertTrue($validator->validate('SI28415779'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new SiVatChecksumValidator();

        $this->assertTrue($validator->validate('SI13557629'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new SiVatChecksumValidator();

        $this->assertFalse($validator->validate('SI28415770'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new SiVatChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
