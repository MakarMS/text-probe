<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\AtUidChecksumValidator;

/**
 * @internal
 */
class AtUidChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new AtUidChecksumValidator();

        $this->assertTrue($validator->validate('ATU30876022'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new AtUidChecksumValidator();

        $this->assertTrue($validator->validate('ATU70617004'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new AtUidChecksumValidator();

        $this->assertFalse($validator->validate('ATU30876020'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new AtUidChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
