<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\PtNifChecksumValidator;

/**
 * @internal
 */
class PtNifChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new PtNifChecksumValidator();

        $this->assertTrue($validator->validate('PT955881234'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new PtNifChecksumValidator();

        $this->assertTrue($validator->validate('PT143794973'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new PtNifChecksumValidator();

        $this->assertFalse($validator->validate('PT955881230'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new PtNifChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
