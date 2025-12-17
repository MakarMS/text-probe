<?php

namespace Tests\Validator\Identity;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Identity\InnValidator;

/**
 * @internal
 */
class InnValidatorTest extends TestCase
{
    public function testValidLegalEntityInnPasses(): void
    {
        $validator = new InnValidator();

        $this->assertTrue($validator->validate('7707083893'));
    }

    public function testValidIndividualInnPasses(): void
    {
        $validator = new InnValidator();

        $this->assertTrue($validator->validate('500100732259'));
    }

    public function testInvalidChecksumFails(): void
    {
        $validator = new InnValidator();

        $this->assertFalse($validator->validate('7707083890'));
    }

    public function testInvalidLengthFails(): void
    {
        $validator = new InnValidator();

        $this->assertFalse($validator->validate('123456789'));
    }

    public function testNormalizationRemovesNonDigits(): void
    {
        $validator = new InnValidator();

        $this->assertTrue($validator->validate('  7707083893 '));
    }
}
