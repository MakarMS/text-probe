<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\EeKmkrChecksumValidator;

/**
 * @internal
 */
class EeKmkrChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new EeKmkrChecksumValidator();

        $this->assertTrue($validator->validate('EE575369975'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new EeKmkrChecksumValidator();

        $this->assertTrue($validator->validate('EE293474498'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new EeKmkrChecksumValidator();

        $this->assertFalse($validator->validate('EE575369970'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new EeKmkrChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
