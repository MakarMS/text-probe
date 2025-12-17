<?php

namespace Tests\Validator\Finance\Price;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Price\PriceValidator;

/**
 * @internal
 */
class PriceValidatorTest extends TestCase
{
    public function testValidWithKnownCurrencyCode(): void
    {
        $validator = new PriceValidator();

        $this->assertTrue($validator->validate('100 USD'));
    }

    public function testValidWithKnownCurrencyCodesSlashSeparated(): void
    {
        $validator = new PriceValidator();

        $this->assertTrue($validator->validate('99 EUR/UAH'));
    }

    public function testValidWithCurrencySymbolOnly(): void
    {
        $validator = new PriceValidator();

        $this->assertTrue($validator->validate('$99.99'));
        $this->assertTrue($validator->validate('1 500₽'));
    }

    public function testRejectsWhenNoDigitsPresent(): void
    {
        $validator = new PriceValidator();

        $this->assertFalse($validator->validate('USD'));
        $this->assertFalse($validator->validate('$'));
        $this->assertFalse($validator->validate('EUR/UAH'));
    }

    public function testRejectsUnknownCurrencyCodeWhenNoSymbol(): void
    {
        $validator = new PriceValidator();

        $this->assertFalse($validator->validate('200 ABC'));
    }

    public function testAcceptsUnknownCurrencyCodeWhenSymbolPresent(): void
    {
        $validator = new PriceValidator();

        $this->assertTrue($validator->validate('200 ABC$'));
        $this->assertTrue($validator->validate('$200 ABC'));
    }

    public function testCaseInsensitiveCurrencyCodeMatching(): void
    {
        $validator = new PriceValidator();

        $this->assertTrue($validator->validate('100 usd'));
        $this->assertTrue($validator->validate('99 eur/uah'));
    }

    public function testMixedCodesInvalidFallsBackToSymbolRequirement(): void
    {
        $validator = new PriceValidator();

        $this->assertFalse($validator->validate('10 USD/ABC'));
        $this->assertTrue($validator->validate('10 USD/ABC$'));
    }
}
