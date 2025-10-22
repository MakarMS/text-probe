<?php

namespace Tests\Validator\Finance\Bank\Account;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Bank\Account\BankRoutingValidator;

class BankRoutingValidatorTest extends TestCase
{
    public function testValidRoutingNumber(): void
    {
        $validator = new BankRoutingValidator();
        $this->assertTrue($validator->validate('111000025'));
    }

    public function testInvalidRoutingNumberWrongChecksum(): void
    {
        $validator = new BankRoutingValidator();
        $this->assertFalse($validator->validate('111000026'));
    }

    public function testInvalidRoutingNumberTooShort(): void
    {
        $validator = new BankRoutingValidator();
        $this->assertFalse($validator->validate('12345678'));
    }

    public function testInvalidRoutingNumberTooLong(): void
    {
        $validator = new BankRoutingValidator();
        $this->assertFalse($validator->validate('1234567890'));
    }

    public function testRoutingNumberWithNonDigits(): void
    {
        $validator = new BankRoutingValidator();
        $this->assertTrue($validator->validate('111-000-025'));
    }

    public function testEmptyStringIsInvalid(): void
    {
        $validator = new BankRoutingValidator();
        $this->assertFalse($validator->validate(''));
    }

    public function testStringWithOnlySpacesIsInvalid(): void
    {
        $validator = new BankRoutingValidator();
        $this->assertFalse($validator->validate('      '));
    }
}
