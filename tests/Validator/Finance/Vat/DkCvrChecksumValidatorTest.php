<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\DkCvrChecksumValidator;

/**
 * @internal
 */
class DkCvrChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new DkCvrChecksumValidator();

        $this->assertTrue($validator->validate('DK01277308'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new DkCvrChecksumValidator();

        $this->assertTrue($validator->validate('DK44590271'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new DkCvrChecksumValidator();

        $this->assertFalse($validator->validate('DK01277300'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new DkCvrChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
