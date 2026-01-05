<?php

namespace Tests\Validator\Identity\TaxNumber;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\TaxNumber\NoFoedselsnummerChecksumValidator;

/**
 * @internal
 */
class NoFoedselsnummerChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue1(): void
    {
        $validator = new NoFoedselsnummerChecksumValidator();

        $this->assertTrue($validator->validate('10000000081'));
    }

    public function testAcceptsValidValue2(): void
    {
        $validator = new NoFoedselsnummerChecksumValidator();

        $this->assertTrue($validator->validate('10000000162'));
    }

    public function testAcceptsValidValue3(): void
    {
        $validator = new NoFoedselsnummerChecksumValidator();

        $this->assertTrue($validator->validate('10000000243'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new NoFoedselsnummerChecksumValidator();

        $this->assertFalse($validator->validate('10000000082'));
    }

    public function testRejectsShortValue(): void
    {
        $validator = new NoFoedselsnummerChecksumValidator();

        $this->assertFalse($validator->validate('1000000008'));
    }

    public function testRejectsLongValue(): void
    {
        $validator = new NoFoedselsnummerChecksumValidator();

        $this->assertFalse($validator->validate('100000000810'));
    }

    public function testRejectsNonDigit(): void
    {
        $validator = new NoFoedselsnummerChecksumValidator();

        $this->assertFalse($validator->validate('1000000008A'));
    }

    public function testRejectsWhitespace(): void
    {
        $validator = new NoFoedselsnummerChecksumValidator();

        $this->assertFalse($validator->validate('10000000081 '));
    }

    public function testRejectsEmpty(): void
    {
        $validator = new NoFoedselsnummerChecksumValidator();

        $this->assertFalse($validator->validate(''));
    }

    public function testRejectsSymbols(): void
    {
        $validator = new NoFoedselsnummerChecksumValidator();

        $this->assertFalse($validator->validate('100000-00081'));
    }
}
