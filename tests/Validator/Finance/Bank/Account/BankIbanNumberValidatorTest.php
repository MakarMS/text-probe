<?php

namespace Tests\Validator\Finance\Bank\Account;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Bank\Account\BankIbanNumberValidator;

class BankIbanNumberValidatorTest extends TestCase
{
    public function testValidIbanSimple(): void
    {
        $validator = new BankIbanNumberValidator();
        $this->assertTrue($validator->validate('DE44500105175407324931'));
    }

    public function testValidIbanWithSpaces(): void
    {
        $validator = new BankIbanNumberValidator();
        $this->assertTrue($validator->validate('DE44 5001 0517 5407 3249 31'));
    }

    public function testValidIbanLowercase(): void
    {
        $validator = new BankIbanNumberValidator();
        $this->assertTrue($validator->validate('de44500105175407324931'));
    }

    public function testInvalidIbanWrongCheck(): void
    {
        $validator = new BankIbanNumberValidator();
        $this->assertFalse($validator->validate('DE44500105175407324932'));
    }

    public function testInvalidIbanTooShort(): void
    {
        $validator = new BankIbanNumberValidator();
        $this->assertFalse($validator->validate('DE44500105'));
    }

    public function testInvalidIbanTooLong(): void
    {
        $validator = new BankIbanNumberValidator();
        $this->assertFalse($validator->validate('DE445001051754073249310000000000000'));
    }

    public function testInvalidIbanWithLettersInWrongPlace(): void
    {
        $validator = new BankIbanNumberValidator();
        $this->assertFalse($validator->validate('DE44$00105175407324931'));
    }

    public function testEmptyStringIsInvalid(): void
    {
        $validator = new BankIbanNumberValidator();
        $this->assertFalse($validator->validate(''));
    }

    public function testStringWithOnlySpacesIsInvalid(): void
    {
        $validator = new BankIbanNumberValidator();
        $this->assertFalse($validator->validate('      '));
    }
}