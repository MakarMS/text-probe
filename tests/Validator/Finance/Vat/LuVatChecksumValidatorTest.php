<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\LuVatChecksumValidator;

/**
 * @internal
 */
class LuVatChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new LuVatChecksumValidator();

        $this->assertTrue($validator->validate('LU01897480'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new LuVatChecksumValidator();

        $this->assertTrue($validator->validate('LU69081266'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new LuVatChecksumValidator();

        $this->assertFalse($validator->validate('LU01897481'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new LuVatChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
