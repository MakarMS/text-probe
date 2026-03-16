<?php

namespace Tests\Validator\Text;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Text\Isbn10ChecksumValidator;

/**
 * @internal
 */
class Isbn10ChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new Isbn10ChecksumValidator();

        $this->assertTrue($validator->validate('0-306-40615-2'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new Isbn10ChecksumValidator();

        $this->assertFalse($validator->validate('0-306-40615-3'));
    }

    public function testAcceptsValidValueWithXChecksum(): void
    {
        $validator = new Isbn10ChecksumValidator();

        $this->assertTrue($validator->validate('0-8044-2957-X'));
    }

    public function testRejectsWrongLength(): void
    {
        $validator = new Isbn10ChecksumValidator();

        $this->assertFalse($validator->validate('030640615'));
        $this->assertFalse($validator->validate('03064061522'));
    }

    public function testRejectsInvalidCharacters(): void
    {
        $validator = new Isbn10ChecksumValidator();

        $this->assertFalse($validator->validate('0-306-4061A-2'));
    }
}
