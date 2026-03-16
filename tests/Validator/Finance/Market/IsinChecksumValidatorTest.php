<?php

namespace Tests\Validator\Finance\Market;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Market\IsinChecksumValidator;

/**
 * @internal
 */
class IsinChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new IsinChecksumValidator();

        $this->assertTrue($validator->validate('US0378331005'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new IsinChecksumValidator();

        $this->assertFalse($validator->validate('US0378331006'));
    }

    public function testRejectsWrongLength(): void
    {
        $validator = new IsinChecksumValidator();

        $this->assertFalse($validator->validate('US037833100'));
        $this->assertFalse($validator->validate('US03783310055'));
    }

    public function testRejectsInvalidPrefix(): void
    {
        $validator = new IsinChecksumValidator();

        $this->assertFalse($validator->validate('1S0378331005'));
    }

    public function testAcceptsAnotherValidIsin(): void
    {
        $validator = new IsinChecksumValidator();

        $this->assertTrue($validator->validate('US5949181045'));
    }
}
