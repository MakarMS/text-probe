<?php

namespace Tests\Validator\Identity\CompanyRegistration;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\CompanyRegistration\EsCifControlValidator;

/**
 * @internal
 */
class EsCifControlValidatorTest extends TestCase
{
    public function testAcceptsValidValue1(): void
    {
        $validator = new EsCifControlValidator();

        $this->assertTrue($validator->validate('B12345674'));
    }

    public function testAcceptsValidValue2(): void
    {
        $validator = new EsCifControlValidator();

        $this->assertTrue($validator->validate('A7654321D'));
    }

    public function testAcceptsValidValue3(): void
    {
        $validator = new EsCifControlValidator();

        $this->assertTrue($validator->validate('B2345678C'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new EsCifControlValidator();

        $this->assertFalse($validator->validate('B12345670'));
    }

    public function testRejectsInvalidPrefix(): void
    {
        $validator = new EsCifControlValidator();

        $this->assertFalse($validator->validate('1B2345674'));
    }

    public function testRejectsShortValue(): void
    {
        $validator = new EsCifControlValidator();

        $this->assertFalse($validator->validate('B1234567'));
    }

    public function testRejectsLongValue(): void
    {
        $validator = new EsCifControlValidator();

        $this->assertFalse($validator->validate('B123456741'));
    }

    public function testRejectsLowercase(): void
    {
        $validator = new EsCifControlValidator();

        $this->assertFalse($validator->validate('b12345674'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new EsCifControlValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }

    public function testRejectsNonDigitMiddle(): void
    {
        $validator = new EsCifControlValidator();

        $this->assertFalse($validator->validate('B12345A74'));
    }
}
