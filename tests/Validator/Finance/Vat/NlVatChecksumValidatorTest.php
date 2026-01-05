<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\NlVatChecksumValidator;

/**
 * @internal
 */
class NlVatChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new NlVatChecksumValidator();

        $this->assertTrue($validator->validate('NL430185303B20'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new NlVatChecksumValidator();

        $this->assertTrue($validator->validate('NL294148358B96'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new NlVatChecksumValidator();

        $this->assertFalse($validator->validate('NL430185303B21'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new NlVatChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
