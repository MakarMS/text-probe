<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\ItVatChecksumValidator;

/**
 * @internal
 */
class ItVatChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new ItVatChecksumValidator();

        $this->assertTrue($validator->validate('IT63069758801'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new ItVatChecksumValidator();

        $this->assertTrue($validator->validate('IT99495551782'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new ItVatChecksumValidator();

        $this->assertFalse($validator->validate('IT63069758800'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new ItVatChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
