<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\GrAfmChecksumValidator;

/**
 * @internal
 */
class GrAfmChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new GrAfmChecksumValidator();

        $this->assertTrue($validator->validate('EL442550431'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new GrAfmChecksumValidator();

        $this->assertTrue($validator->validate('EL153297373'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new GrAfmChecksumValidator();

        $this->assertFalse($validator->validate('EL442550430'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new GrAfmChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
