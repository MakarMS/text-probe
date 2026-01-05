<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\HuVatChecksumValidator;

/**
 * @internal
 */
class HuVatChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new HuVatChecksumValidator();

        $this->assertTrue($validator->validate('HU70473056'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new HuVatChecksumValidator();

        $this->assertTrue($validator->validate('HU24855086'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new HuVatChecksumValidator();

        $this->assertFalse($validator->validate('HU70473050'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new HuVatChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
