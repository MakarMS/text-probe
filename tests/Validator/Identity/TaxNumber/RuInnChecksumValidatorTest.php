<?php

namespace Tests\Validator\Identity\TaxNumber;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\TaxNumber\RuInnChecksumValidator;

/**
 * @internal
 */
class RuInnChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue1(): void
    {
        $validator = new RuInnChecksumValidator();

        $this->assertTrue($validator->validate('7707083893'));
    }

    public function testAcceptsValidValue2(): void
    {
        $validator = new RuInnChecksumValidator();

        $this->assertTrue($validator->validate('7811087301'));
    }

    public function testAcceptsValidValue3(): void
    {
        $validator = new RuInnChecksumValidator();

        $this->assertTrue($validator->validate('500100732259'));
    }

    public function testAcceptsValidValue4(): void
    {
        $validator = new RuInnChecksumValidator();

        $this->assertTrue($validator->validate('502901002924'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new RuInnChecksumValidator();

        $this->assertFalse($validator->validate('7707083894'));
    }

    public function testRejectsInvalidChecksumSecond(): void
    {
        $validator = new RuInnChecksumValidator();

        $this->assertFalse($validator->validate('500100732258'));
    }

    public function testRejectsShortValue(): void
    {
        $validator = new RuInnChecksumValidator();

        $this->assertFalse($validator->validate('770708389'));
    }

    public function testRejectsLongValue(): void
    {
        $validator = new RuInnChecksumValidator();

        $this->assertFalse($validator->validate('7707083893123'));
    }

    public function testRejectsNonDigit(): void
    {
        $validator = new RuInnChecksumValidator();

        $this->assertFalse($validator->validate('770708389A'));
    }

    public function testRejectsEmpty(): void
    {
        $validator = new RuInnChecksumValidator();

        $this->assertFalse($validator->validate(''));
    }

    public function testRejectsWhitespace(): void
    {
        $validator = new RuInnChecksumValidator();

        $this->assertFalse($validator->validate('7707083893 '));
    }
}
