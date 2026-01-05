<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\SeVatChecksumValidator;

/**
 * @internal
 */
class SeVatChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new SeVatChecksumValidator();

        $this->assertTrue($validator->validate('SE916149705301'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new SeVatChecksumValidator();

        $this->assertTrue($validator->validate('SE649986690001'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new SeVatChecksumValidator();

        $this->assertFalse($validator->validate('SE916149705300'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new SeVatChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
