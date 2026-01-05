<?php

namespace Tests\Validator\Identity\TaxNumber;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\TaxNumber\ItCodiceFiscaleControlCharValidator;

/**
 * @internal
 */
class ItCodiceFiscaleControlCharValidatorTest extends TestCase
{
    public function testAcceptsValidValue1(): void
    {
        $validator = new ItCodiceFiscaleControlCharValidator();

        $this->assertTrue($validator->validate('RSSMRA85T10A562S'));
    }

    public function testAcceptsValidValue2(): void
    {
        $validator = new ItCodiceFiscaleControlCharValidator();

        $this->assertTrue($validator->validate('VRDLGI90A01H501G'));
    }

    public function testAcceptsValidValue3(): void
    {
        $validator = new ItCodiceFiscaleControlCharValidator();

        $this->assertTrue($validator->validate('BNCLGU87M05H501L'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new ItCodiceFiscaleControlCharValidator();

        $this->assertFalse($validator->validate('RSSMRA85T10A562A'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new ItCodiceFiscaleControlCharValidator();

        $this->assertFalse($validator->validate('rssmra85t10a562s'));
    }

    public function testRejectsShortValue(): void
    {
        $validator = new ItCodiceFiscaleControlCharValidator();

        $this->assertFalse($validator->validate('RSSMRA85T10A56'));
    }

    public function testRejectsLongValue(): void
    {
        $validator = new ItCodiceFiscaleControlCharValidator();

        $this->assertFalse($validator->validate('RSSMRA85T10A562SS'));
    }

    public function testRejectsNumericOnly(): void
    {
        $validator = new ItCodiceFiscaleControlCharValidator();

        $this->assertFalse($validator->validate('1234567890123456'));
    }

    public function testRejectsInvalidChar(): void
    {
        $validator = new ItCodiceFiscaleControlCharValidator();

        $this->assertFalse($validator->validate('RSSMRA85T10A56@S'));
    }

    public function testRejectsMissingLetter(): void
    {
        $validator = new ItCodiceFiscaleControlCharValidator();

        $this->assertFalse($validator->validate('RSSMRA85T10A5621'));
    }
}
