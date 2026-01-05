<?php

namespace Tests\Validator\Identity\CompanyRegistration;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\CompanyRegistration\NoOrganisasjonsnummerChecksumValidator;

/**
 * @internal
 */
class NoOrganisasjonsnummerChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue1(): void
    {
        $validator = new NoOrganisasjonsnummerChecksumValidator();

        $this->assertTrue($validator->validate('100000008'));
    }

    public function testAcceptsValidValue2(): void
    {
        $validator = new NoOrganisasjonsnummerChecksumValidator();

        $this->assertTrue($validator->validate('100000016'));
    }

    public function testAcceptsValidValue3(): void
    {
        $validator = new NoOrganisasjonsnummerChecksumValidator();

        $this->assertTrue($validator->validate('123456785'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new NoOrganisasjonsnummerChecksumValidator();

        $this->assertFalse($validator->validate('100000009'));
    }

    public function testRejectsShortValue(): void
    {
        $validator = new NoOrganisasjonsnummerChecksumValidator();

        $this->assertFalse($validator->validate('10000000'));
    }

    public function testRejectsLongValue(): void
    {
        $validator = new NoOrganisasjonsnummerChecksumValidator();

        $this->assertFalse($validator->validate('1000000080'));
    }

    public function testRejectsNonDigit(): void
    {
        $validator = new NoOrganisasjonsnummerChecksumValidator();

        $this->assertFalse($validator->validate('10000000A'));
    }

    public function testRejectsWhitespace(): void
    {
        $validator = new NoOrganisasjonsnummerChecksumValidator();

        $this->assertFalse($validator->validate('100000008 '));
    }

    public function testRejectsSymbols(): void
    {
        $validator = new NoOrganisasjonsnummerChecksumValidator();

        $this->assertFalse($validator->validate('100-000-008'));
    }

    public function testRejectsEmpty(): void
    {
        $validator = new NoOrganisasjonsnummerChecksumValidator();

        $this->assertFalse($validator->validate(''));
    }
}
