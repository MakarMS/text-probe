<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\CyVatChecksumValidator;

/**
 * @internal
 */
class CyVatChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new CyVatChecksumValidator();

        $this->assertTrue($validator->validate('CY05866324G'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new CyVatChecksumValidator();

        $this->assertTrue($validator->validate('CY01812357Y'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new CyVatChecksumValidator();

        $this->assertFalse($validator->validate('CY058663240'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new CyVatChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
