<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\CzDicChecksumValidator;

/**
 * @internal
 */
class CzDicChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new CzDicChecksumValidator();

        $this->assertTrue($validator->validate('CZ194308303'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new CzDicChecksumValidator();

        $this->assertTrue($validator->validate('CZ56743483'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new CzDicChecksumValidator();

        $this->assertFalse($validator->validate('CZ194308300'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new CzDicChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
