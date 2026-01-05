<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\HrOibChecksumValidator;

/**
 * @internal
 */
class HrOibChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new HrOibChecksumValidator();

        $this->assertTrue($validator->validate('HR96805128475'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new HrOibChecksumValidator();

        $this->assertTrue($validator->validate('HR11889587344'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new HrOibChecksumValidator();

        $this->assertFalse($validator->validate('HR96805128470'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new HrOibChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
