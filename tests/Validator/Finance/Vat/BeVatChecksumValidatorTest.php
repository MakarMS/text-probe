<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\BeVatChecksumValidator;

/**
 * @internal
 */
class BeVatChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new BeVatChecksumValidator();

        $this->assertTrue($validator->validate('BE0143773497'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new BeVatChecksumValidator();

        $this->assertTrue($validator->validate('BE849431869'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new BeVatChecksumValidator();

        $this->assertFalse($validator->validate('BE0143773490'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new BeVatChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
