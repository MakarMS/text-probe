<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\XiVatChecksumValidator;

/**
 * @internal
 */
class XiVatChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new XiVatChecksumValidator();

        $this->assertTrue($validator->validate('XI816110862'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new XiVatChecksumValidator();

        $this->assertTrue($validator->validate('XI411367775'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new XiVatChecksumValidator();

        $this->assertFalse($validator->validate('XI816110860'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new XiVatChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
