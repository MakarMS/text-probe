<?php

namespace Tests\Validator\Social;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Social\UsSocialSecurityNumberValidator;

/**
 * @internal
 */
class UsSocialSecurityNumberValidatorTest extends TestCase
{
    public function testValidSsn(): void
    {
        $validator = new UsSocialSecurityNumberValidator();

        $this->assertTrue($validator->validate('123-45-6789'));
    }

    public function testRejectsInvalidFormat(): void
    {
        $validator = new UsSocialSecurityNumberValidator();

        $this->assertFalse($validator->validate('123456789'));
        $this->assertFalse($validator->validate('123-456-789'));
        $this->assertFalse($validator->validate('12-34-5678'));
        $this->assertFalse($validator->validate('abc-de-ghij'));
    }

    public function testRejectsArea000(): void
    {
        $validator = new UsSocialSecurityNumberValidator();

        $this->assertFalse($validator->validate('000-12-3456'));
    }

    public function testRejectsArea666(): void
    {
        $validator = new UsSocialSecurityNumberValidator();

        $this->assertFalse($validator->validate('666-12-3456'));
    }

    public function testRejectsArea900AndAbove(): void
    {
        $validator = new UsSocialSecurityNumberValidator();

        $this->assertFalse($validator->validate('900-12-3456'));
        $this->assertFalse($validator->validate('999-12-3456'));
    }

    public function testRejectsGroup00(): void
    {
        $validator = new UsSocialSecurityNumberValidator();

        $this->assertFalse($validator->validate('123-00-6789'));
    }

    public function testRejectsSerial0000(): void
    {
        $validator = new UsSocialSecurityNumberValidator();

        $this->assertFalse($validator->validate('123-45-0000'));
    }
}
