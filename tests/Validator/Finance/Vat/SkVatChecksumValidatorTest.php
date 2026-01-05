<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\SkVatChecksumValidator;

/**
 * @internal
 */
class SkVatChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new SkVatChecksumValidator();

        $this->assertTrue($validator->validate('SK5804125481'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new SkVatChecksumValidator();

        $this->assertTrue($validator->validate('SK8636599499'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new SkVatChecksumValidator();

        $this->assertFalse($validator->validate('SK5804125480'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new SkVatChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
