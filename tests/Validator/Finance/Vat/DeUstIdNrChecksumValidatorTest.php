<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\DeUstIdNrChecksumValidator;

/**
 * @internal
 */
class DeUstIdNrChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new DeUstIdNrChecksumValidator();

        $this->assertTrue($validator->validate('DE685385472'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new DeUstIdNrChecksumValidator();

        $this->assertTrue($validator->validate('DE650331376'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new DeUstIdNrChecksumValidator();

        $this->assertFalse($validator->validate('DE685385470'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new DeUstIdNrChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
