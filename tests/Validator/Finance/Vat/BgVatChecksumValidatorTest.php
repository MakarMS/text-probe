<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\BgVatChecksumValidator;

/**
 * @internal
 */
class BgVatChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new BgVatChecksumValidator();

        $this->assertTrue($validator->validate('BG228380277'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new BgVatChecksumValidator();

        $this->assertTrue($validator->validate('BG449169427'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new BgVatChecksumValidator();

        $this->assertFalse($validator->validate('BG228380270'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new BgVatChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
