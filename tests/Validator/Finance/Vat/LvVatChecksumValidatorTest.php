<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\LvVatChecksumValidator;

/**
 * @internal
 */
class LvVatChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new LvVatChecksumValidator();

        $this->assertTrue($validator->validate('LV08116995373'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new LvVatChecksumValidator();

        $this->assertTrue($validator->validate('LV59829349456'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new LvVatChecksumValidator();

        $this->assertFalse($validator->validate('LV08116995370'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new LvVatChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
