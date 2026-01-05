<?php

namespace Tests\Validator\Finance\Currency;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Currency\ISO4217WhitelistValidator;

/**
 * @internal
 */
class ISO4217WhitelistValidatorTest extends TestCase
{
    public function testAcceptsKnownCurrencyCodes(): void
    {
        $validator = new ISO4217WhitelistValidator();

        $this->assertTrue($validator->validate('USD'));
        $this->assertTrue($validator->validate('EUR'));
        $this->assertTrue($validator->validate('JPY'));
    }

    public function testAcceptsLowercaseCodes(): void
    {
        $validator = new ISO4217WhitelistValidator();

        $this->assertTrue($validator->validate('usd'));
        $this->assertTrue($validator->validate('eur'));
    }

    public function testRejectsUnknownCodes(): void
    {
        $validator = new ISO4217WhitelistValidator();

        $this->assertFalse($validator->validate('AAA'));
        $this->assertFalse($validator->validate('ZZZ'));
    }

    public function testRejectsInvalidLengths(): void
    {
        $validator = new ISO4217WhitelistValidator();

        $this->assertFalse($validator->validate('US'));
        $this->assertFalse($validator->validate('USDA'));
    }
}
