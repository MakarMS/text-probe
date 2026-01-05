<?php

namespace Tests\Validator\Identity\MedicalPolicy;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\MedicalPolicy\GbNhsChecksumValidator;

/**
 * @internal
 */
class GbNhsChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue1(): void
    {
        $validator = new GbNhsChecksumValidator();

        $this->assertTrue($validator->validate('1000000001'));
    }

    public function testAcceptsValidValue2(): void
    {
        $validator = new GbNhsChecksumValidator();

        $this->assertTrue($validator->validate('1000000028'));
    }

    public function testAcceptsValidValue3(): void
    {
        $validator = new GbNhsChecksumValidator();

        $this->assertTrue($validator->validate('100 000 0036'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new GbNhsChecksumValidator();

        $this->assertFalse($validator->validate('1000000002'));
    }

    public function testRejectsShortValue(): void
    {
        $validator = new GbNhsChecksumValidator();

        $this->assertFalse($validator->validate('100000001'));
    }

    public function testRejectsLongValue(): void
    {
        $validator = new GbNhsChecksumValidator();

        $this->assertFalse($validator->validate('10000000011'));
    }

    public function testRejectsNonDigit(): void
    {
        $validator = new GbNhsChecksumValidator();

        $this->assertFalse($validator->validate('100000000A'));
    }

    public function testRejectsWhitespaceSuffix(): void
    {
        $validator = new GbNhsChecksumValidator();

        $this->assertFalse($validator->validate('1000000001 '));
    }

    public function testRejectsSymbols(): void
    {
        $validator = new GbNhsChecksumValidator();

        $this->assertFalse($validator->validate('100-000-0001'));
    }

    public function testRejectsEmpty(): void
    {
        $validator = new GbNhsChecksumValidator();

        $this->assertFalse($validator->validate(''));
    }
}
