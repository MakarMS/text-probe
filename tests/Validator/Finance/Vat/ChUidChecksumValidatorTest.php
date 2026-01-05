<?php

namespace Tests\Validator\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Vat\ChUidChecksumValidator;

/**
 * @internal
 */
class ChUidChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new ChUidChecksumValidator();

        $this->assertTrue($validator->validate('CHE999945575MWST'));
    }

    public function testAcceptsSecondValidValue(): void
    {
        $validator = new ChUidChecksumValidator();

        $this->assertTrue($validator->validate('CHE499282565MWST'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new ChUidChecksumValidator();

        $this->assertFalse($validator->validate('CHE999945576MWST'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new ChUidChecksumValidator();

        $this->assertFalse($validator->validate('INVALID'));
    }
}
