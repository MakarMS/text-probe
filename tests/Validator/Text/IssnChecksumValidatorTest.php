<?php

namespace Tests\Validator\Text;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Text\IssnChecksumValidator;

/**
 * @internal
 */
class IssnChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new IssnChecksumValidator();

        $this->assertTrue($validator->validate('0317-8471'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new IssnChecksumValidator();

        $this->assertFalse($validator->validate('0317-8472'));
    }

    public function testAcceptsXChecksum(): void
    {
        $validator = new IssnChecksumValidator();

        $this->assertTrue($validator->validate('2434-561X'));
    }

    public function testRejectsWrongLength(): void
    {
        $validator = new IssnChecksumValidator();

        $this->assertFalse($validator->validate('0317-847'));
        $this->assertFalse($validator->validate('0317-84711'));
    }

    public function testRejectsInvalidCharacters(): void
    {
        $validator = new IssnChecksumValidator();

        $this->assertFalse($validator->validate('0317-84A1'));
    }
}
