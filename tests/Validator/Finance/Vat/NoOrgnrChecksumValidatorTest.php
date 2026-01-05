<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\NoOrgnrChecksumValidator;

/**
 * @internal
 */
class NoOrgnrChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new NoOrgnrChecksumValidator();

        $this->assertTrue($validator->validate('NO133640932MVA'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new NoOrgnrChecksumValidator();

        $this->assertTrue($validator->validate('NO980117162MVA'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new NoOrgnrChecksumValidator();

        $this->assertFalse($validator->validate('NO133640934MVA'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new NoOrgnrChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
