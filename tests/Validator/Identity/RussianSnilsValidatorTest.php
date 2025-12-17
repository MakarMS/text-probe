<?php

namespace Tests\Validator\Identity;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\RussianSnilsValidator;

/**
 * @internal
 */
class RussianSnilsValidatorTest extends TestCase
{
    public function testValidSnilsWithHyphensAndSpace(): void
    {
        $validator = new RussianSnilsValidator();

        $this->assertTrue($validator->validate('112-233-445 95'));
    }

    public function testValidSnilsWithoutSeparators(): void
    {
        $validator = new RussianSnilsValidator();

        $this->assertTrue($validator->validate('11223344595'));
    }

    public function testRejectsWrongLength(): void
    {
        $validator = new RussianSnilsValidator();

        $this->assertFalse($validator->validate('112-233-445 9'));
        $this->assertFalse($validator->validate('112-233-445 955'));
    }

    public function testRejectsAllZeroFirstNineDigits(): void
    {
        $validator = new RussianSnilsValidator();

        $this->assertFalse($validator->validate('000-000-000 00'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new RussianSnilsValidator();

        $this->assertFalse($validator->validate('112-233-445 96'));
    }

    public function testAcceptsSumEquals100Or101Checksum00(): void
    {
        $validator = new RussianSnilsValidator();

        $this->assertTrue($validator->validate('087-654-303 00'));
    }

    public function testRejectsNonDigitsOnly(): void
    {
        $validator = new RussianSnilsValidator();

        $this->assertFalse($validator->validate('no snils here'));
    }
}
