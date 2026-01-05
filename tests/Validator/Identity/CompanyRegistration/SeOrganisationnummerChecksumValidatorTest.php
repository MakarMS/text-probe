<?php

namespace Tests\Validator\Identity\CompanyRegistration;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\CompanyRegistration\SeOrganisationnummerChecksumValidator;

/**
 * @internal
 */
class SeOrganisationnummerChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue1(): void
    {
        $validator = new SeOrganisationnummerChecksumValidator();

        $this->assertTrue($validator->validate('556016-0680'));
    }

    public function testAcceptsValidValue2(): void
    {
        $validator = new SeOrganisationnummerChecksumValidator();

        $this->assertTrue($validator->validate('556123-4567'));
    }

    public function testAcceptsValidValue3(): void
    {
        $validator = new SeOrganisationnummerChecksumValidator();

        $this->assertTrue($validator->validate('212000-0829'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new SeOrganisationnummerChecksumValidator();

        $this->assertFalse($validator->validate('556016-0681'));
    }

    public function testRejectsShortValue(): void
    {
        $validator = new SeOrganisationnummerChecksumValidator();

        $this->assertFalse($validator->validate('556016-068'));
    }

    public function testRejectsLongValue(): void
    {
        $validator = new SeOrganisationnummerChecksumValidator();

        $this->assertFalse($validator->validate('556016-06800'));
    }

    public function testRejectsMissingDash(): void
    {
        $validator = new SeOrganisationnummerChecksumValidator();

        $this->assertFalse($validator->validate('5560160680'));
    }

    public function testRejectsNonDigit(): void
    {
        $validator = new SeOrganisationnummerChecksumValidator();

        $this->assertFalse($validator->validate('556016-068A'));
    }

    public function testRejectsWhitespace(): void
    {
        $validator = new SeOrganisationnummerChecksumValidator();

        $this->assertFalse($validator->validate('556016-0680 '));
    }

    public function testRejectsEmpty(): void
    {
        $validator = new SeOrganisationnummerChecksumValidator();

        $this->assertFalse($validator->validate(''));
    }
}
