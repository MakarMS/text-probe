<?php

namespace Tests\Validator\Finance\Market;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Market\LeiChecksumValidator;

/**
 * @internal
 */
class LeiChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new LeiChecksumValidator();

        $this->assertTrue($validator->validate('5493001KJTIIGC8Y1R35'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new LeiChecksumValidator();

        $this->assertFalse($validator->validate('5493001KJTIIGC8Y1R36'));
    }

    public function testRejectsWrongLength(): void
    {
        $validator = new LeiChecksumValidator();

        $this->assertFalse($validator->validate('5493001KJTIIGC8Y1R3'));
        $this->assertFalse($validator->validate('5493001KJTIIGC8Y1R355'));
    }

    public function testRejectsInvalidCharacters(): void
    {
        $validator = new LeiChecksumValidator();

        $this->assertFalse($validator->validate('5493001KJTIIGC8Y1R$5'));
    }

    public function testAcceptsTrimmedInput(): void
    {
        $validator = new LeiChecksumValidator();

        $this->assertTrue($validator->validate(' 5493001KJTIIGC8Y1R35 '));
    }
}
