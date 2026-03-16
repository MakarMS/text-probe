<?php

namespace Tests\Validator\Text;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Text\Isbn13ChecksumValidator;

/**
 * @internal
 */
class Isbn13ChecksumValidatorTest extends TestCase
{
    public function testAcceptsValidValue(): void
    {
        $validator = new Isbn13ChecksumValidator();

        $this->assertTrue($validator->validate('978-0-306-40615-7'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new Isbn13ChecksumValidator();

        $this->assertFalse($validator->validate('978-0-306-40615-8'));
    }

    public function testAccepts979Prefix(): void
    {
        $validator = new Isbn13ChecksumValidator();

        $this->assertTrue($validator->validate('9791090636071'));
    }

    public function testRejectsWrongLength(): void
    {
        $validator = new Isbn13ChecksumValidator();

        $this->assertFalse($validator->validate('978030640615'));
        $this->assertFalse($validator->validate('97803064061570'));
    }

    public function testRejectsUnsupportedPrefix(): void
    {
        $validator = new Isbn13ChecksumValidator();

        $this->assertFalse($validator->validate('9770306406157'));
    }
}
