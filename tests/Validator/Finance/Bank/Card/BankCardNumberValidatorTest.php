<?php

namespace Tests\Validator\Finance\Bank\Card;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\BankCardNumberValidator;

class BankCardNumberValidatorTest extends TestCase
{
    public function testValidVisaCard(): void
    {
        $validator = new BankCardNumberValidator();
        $this->assertTrue($validator->validate('4111111111111111'));
    }

    public function testValidMasterCard(): void
    {
        $validator = new BankCardNumberValidator();
        $this->assertTrue($validator->validate('5500000000000004'));
    }

    public function testValidAmexCard(): void
    {
        $validator = new BankCardNumberValidator();
        $this->assertTrue($validator->validate('340000000000009'));
    }

    public function testValidCardWithSpaces(): void
    {
        $validator = new BankCardNumberValidator();
        $this->assertTrue($validator->validate('4111 1111 1111 1111'));
    }

    public function testValidCardWithDashes(): void
    {
        $validator = new BankCardNumberValidator();
        $this->assertTrue($validator->validate('4111-1111-1111-1111'));
    }

    public function testInvalidCardWrongLuhn(): void
    {
        $validator = new BankCardNumberValidator();
        $this->assertFalse($validator->validate('4111111111111112'));
    }

    public function testInvalidCardTooShort(): void
    {
        $validator = new BankCardNumberValidator();
        $this->assertFalse($validator->validate('411111111111'));
    }

    public function testInvalidCardTooLong(): void
    {
        $validator = new BankCardNumberValidator();
        $this->assertFalse($validator->validate('411111111111111111111'));
    }

    public function testInvalidCardWithLetters(): void
    {
        $validator = new BankCardNumberValidator();
        $this->assertFalse($validator->validate('4111a11111111111'));
    }

    public function testValid13DigitCard(): void
    {
        $validator = new BankCardNumberValidator();
        $this->assertTrue($validator->validate('4222222222222'));
    }

    public function testValid19DigitCard(): void
    {
        $validator = new BankCardNumberValidator();
        $this->assertTrue($validator->validate('4154883471956491746'));
    }

    public function testValidCardWithMixedSeparators(): void
    {
        $validator = new BankCardNumberValidator();
        $this->assertTrue($validator->validate('4111-1111 1111-1111'));
    }

    public function testEmptyStringIsInvalid(): void
    {
        $validator = new BankCardNumberValidator();
        $this->assertFalse($validator->validate(''));
    }

    public function testStringWithOnlySpacesIsInvalid(): void
    {
        $validator = new BankCardNumberValidator();
        $this->assertFalse($validator->validate('      '));
    }
}
