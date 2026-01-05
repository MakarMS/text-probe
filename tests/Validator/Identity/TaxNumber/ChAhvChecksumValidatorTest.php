<?php

namespace Tests\Validator\Identity\TaxNumber;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\TaxNumber\ChAhvChecksumValidator;

/**
 * @internal
 */
class ChAhvChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue1(): void
    {
        $validator = new ChAhvChecksumValidator();

        $this->assertTrue($validator->validate('756.1234.5678.97'));
    }

    public function testAcceptsValidValue2(): void
    {
        $validator = new ChAhvChecksumValidator();

        $this->assertTrue($validator->validate('756.9876.5432.17'));
    }

    public function testAcceptsValidValue3(): void
    {
        $validator = new ChAhvChecksumValidator();

        $this->assertTrue($validator->validate('756.1111.1111.13'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new ChAhvChecksumValidator();

        $this->assertFalse($validator->validate('756.1234.5678.96'));
    }

    public function testRejectsMissingDots(): void
    {
        $validator = new ChAhvChecksumValidator();

        $this->assertFalse($validator->validate('7561234567897'));
    }

    public function testRejectsShortValue(): void
    {
        $validator = new ChAhvChecksumValidator();

        $this->assertFalse($validator->validate('756.1234.5678.9'));
    }

    public function testRejectsLongValue(): void
    {
        $validator = new ChAhvChecksumValidator();

        $this->assertFalse($validator->validate('756.1234.5678.970'));
    }

    public function testRejectsNonDigit(): void
    {
        $validator = new ChAhvChecksumValidator();

        $this->assertFalse($validator->validate('756.1234.5678.9A'));
    }

    public function testRejectsEmpty(): void
    {
        $validator = new ChAhvChecksumValidator();

        $this->assertFalse($validator->validate(''));
    }

    public function testRejectsSymbols(): void
    {
        $validator = new ChAhvChecksumValidator();

        $this->assertFalse($validator->validate('756.1234.5678-97'));
    }
}
