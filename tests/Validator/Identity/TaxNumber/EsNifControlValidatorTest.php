<?php

namespace Tests\Validator\Identity\TaxNumber;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\TaxNumber\EsNifControlValidator;

/**
 * @internal
 */
class EsNifControlValidatorTest extends TestCase
{
    public function testAcceptsValidValue1(): void
    {
        $validator = new EsNifControlValidator();

        $this->assertTrue($validator->validate('12345678Z'));
    }

    public function testAcceptsValidValue2(): void
    {
        $validator = new EsNifControlValidator();

        $this->assertTrue($validator->validate('00000000T'));
    }

    public function testAcceptsValidValue3(): void
    {
        $validator = new EsNifControlValidator();

        $this->assertTrue($validator->validate('Y7654321G'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new EsNifControlValidator();

        $this->assertFalse($validator->validate('12345678A'));
    }

    public function testRejectsInvalidPrefix(): void
    {
        $validator = new EsNifControlValidator();

        $this->assertFalse($validator->validate('W7654321G'));
    }

    public function testRejectsNumericSuffix(): void
    {
        $validator = new EsNifControlValidator();

        $this->assertFalse($validator->validate('123456789'));
    }

    public function testRejectsShortValue(): void
    {
        $validator = new EsNifControlValidator();

        $this->assertFalse($validator->validate('1234567Z'));
    }

    public function testRejectsLongValue(): void
    {
        $validator = new EsNifControlValidator();

        $this->assertFalse($validator->validate('123456789Z'));
    }

    public function testRejectsLowercase(): void
    {
        $validator = new EsNifControlValidator();

        $this->assertFalse($validator->validate('x1234567l'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new EsNifControlValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
