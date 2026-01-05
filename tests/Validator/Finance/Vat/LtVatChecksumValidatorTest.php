<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\LtVatChecksumValidator;

/**
 * @internal
 */
class LtVatChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new LtVatChecksumValidator();

        $this->assertTrue($validator->validate('LT286889588'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new LtVatChecksumValidator();

        $this->assertTrue($validator->validate('LT931118271229'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new LtVatChecksumValidator();

        $this->assertFalse($validator->validate('LT286889580'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new LtVatChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
