<?php

namespace Tests\Validator\Barcode;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Barcode\Gtin14ChecksumValidator;

/**
 * @internal
 */
class Gtin14ChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new Gtin14ChecksumValidator();

        $this->assertTrue($validator->validate('10012345678902'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new Gtin14ChecksumValidator();

        $this->assertFalse($validator->validate('10012345678903'));
    }

    public function testRejectsWrongLength(): void
    {
        $validator = new Gtin14ChecksumValidator();

        $this->assertFalse($validator->validate('1001234567890'));
        $this->assertFalse($validator->validate('100123456789021'));
    }

    public function testRejectsNonDigitPayload(): void
    {
        $validator = new Gtin14ChecksumValidator();

        $this->assertFalse($validator->validate('ABCDEFGHIJKLMN'));
    }

    public function testAcceptsFormattedDigits(): void
    {
        $validator = new Gtin14ChecksumValidator();

        $this->assertTrue($validator->validate('1001 2345 6789 02'));
    }
}
