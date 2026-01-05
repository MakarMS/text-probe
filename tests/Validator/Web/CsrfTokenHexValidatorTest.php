<?php

namespace Tests\Validator\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Web\CsrfTokenHexValidator;

/**
 * @internal
 */
class CsrfTokenHexValidatorTest extends TestCase
{
    public function testAcceptsValidSample(): void
    {
        $validator = new CsrfTokenHexValidator();

        $this->assertTrue($validator->validate('0123456789abcdef0123456789abcdef'));
    }

    public function testAcceptsSecondValidSample(): void
    {
        $validator = new CsrfTokenHexValidator();

        $this->assertTrue($validator->validate('abcdefabcdefabcdefabcdefabcdefabcdefabcdefabcdef'));
    }

    public function testRejectsInvalidSample(): void
    {
        $validator = new CsrfTokenHexValidator();

        $this->assertFalse($validator->validate('0123456789abcdef0123456789abcde'));
    }

    public function testRejectsSecondInvalidSample(): void
    {
        $validator = new CsrfTokenHexValidator();

        $this->assertFalse($validator->validate('0123456789abcdef0123456789abcdeg'));
    }

    public function testRejectsEmptyString(): void
    {
        $validator = new CsrfTokenHexValidator();

        $this->assertFalse($validator->validate(''));
    }

    public function testRejectsWhitespace(): void
    {
        $validator = new CsrfTokenHexValidator();

        $this->assertFalse($validator->validate('   '));
    }

    public function testRejectsSymbols(): void
    {
        $validator = new CsrfTokenHexValidator();

        $this->assertFalse($validator->validate('@@@'));
    }

    public function testRejectsMixedText(): void
    {
        $validator = new CsrfTokenHexValidator();

        $this->assertFalse($validator->validate('random-text'));
    }

    public function testRejectsNewlines(): void
    {
        $validator = new CsrfTokenHexValidator();

        $this->assertFalse($validator->validate("\n\t"));
    }

    public function testRejectsNullByte(): void
    {
        $validator = new CsrfTokenHexValidator();

        $this->assertFalse($validator->validate("\0"));
    }
}
