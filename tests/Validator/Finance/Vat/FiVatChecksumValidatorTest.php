<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\FiVatChecksumValidator;

/**
 * @internal
 */
class FiVatChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new FiVatChecksumValidator();

        $this->assertTrue($validator->validate('FI79217914'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new FiVatChecksumValidator();

        $this->assertTrue($validator->validate('FI98283642'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new FiVatChecksumValidator();

        $this->assertFalse($validator->validate('FI79217910'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new FiVatChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
