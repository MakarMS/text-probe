<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\FrVatChecksumValidator;

/**
 * @internal
 */
class FrVatChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new FrVatChecksumValidator();

        $this->assertTrue($validator->validate('FR17336019286'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new FrVatChecksumValidator();

        $this->assertTrue($validator->validate('FR06124937065'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new FrVatChecksumValidator();

        $this->assertFalse($validator->validate('FR17336019280'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new FrVatChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
