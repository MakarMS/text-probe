<?php

namespace Tests\Validator\Finance\Company;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Company\OgrnNumberValidator;

/**
 * @internal
 */
class OgrnNumberValidatorTest extends TestCase
{
    public function testValidOgrn(): void
    {
        $validator = new OgrnNumberValidator();

        $this->assertTrue($validator->validate('1027700132195'));
    }

    public function testInvalidChecksum(): void
    {
        $validator = new OgrnNumberValidator();

        $this->assertFalse($validator->validate('1027700132194'));
    }

    public function testTooShort(): void
    {
        $validator = new OgrnNumberValidator();

        $this->assertFalse($validator->validate('123456789012'));
    }

    public function testTooLong(): void
    {
        $validator = new OgrnNumberValidator();

        $this->assertFalse($validator->validate('10277001321951'));
    }

    public function testNonDigitCharacters(): void
    {
        $validator = new OgrnNumberValidator();

        $this->assertFalse($validator->validate('10277001321A5'));
    }
}
