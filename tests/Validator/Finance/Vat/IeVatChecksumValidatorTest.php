<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\IeVatChecksumValidator;

/**
 * @internal
 */
class IeVatChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new IeVatChecksumValidator();

        $this->assertTrue($validator->validate('IE9429088M'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new IeVatChecksumValidator();

        $this->assertTrue($validator->validate('IE1091640K'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new IeVatChecksumValidator();

        $this->assertFalse($validator->validate('IE94290880'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new IeVatChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
