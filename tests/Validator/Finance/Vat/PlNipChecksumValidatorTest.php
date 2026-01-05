<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\PlNipChecksumValidator;

/**
 * @internal
 */
class PlNipChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new PlNipChecksumValidator();

        $this->assertTrue($validator->validate('PL3654345877'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new PlNipChecksumValidator();

        $this->assertTrue($validator->validate('PL9082421958'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new PlNipChecksumValidator();

        $this->assertFalse($validator->validate('PL3654345870'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new PlNipChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
