<?php

namespace Tests\Validator\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Security\PrivateKeyBlockValidator;

/**
 * @internal
 */
class PrivateKeyBlockValidatorTest extends TestCase
{
    public function testAcceptsValidSample(): void
    {
        $validator = new PrivateKeyBlockValidator();

        $this->assertTrue($validator->validate("-----BEGIN PRIVATE KEY-----\nQUJDRA==\n-----END PRIVATE KEY-----"));
    }

    public function testAcceptsSecondValidSample(): void
    {
        $validator = new PrivateKeyBlockValidator();

        $this->assertTrue($validator->validate("-----BEGIN RSA PRIVATE KEY-----\nYWJjZA==\n-----END RSA PRIVATE KEY-----"));
    }

    public function testRejectsInvalidSample(): void
    {
        $validator = new PrivateKeyBlockValidator();

        $this->assertFalse($validator->validate("-----BEGIN PRIVATE KEY-----\n***\n-----END PRIVATE KEY-----"));
    }

    public function testRejectsSecondInvalidSample(): void
    {
        $validator = new PrivateKeyBlockValidator();

        $this->assertFalse($validator->validate("-----BEGIN PRIVATE KEY-----\n@@@\n-----END PRIVATE KEY-----"));
    }

    public function testRejectsEmptyString(): void
    {
        $validator = new PrivateKeyBlockValidator();

        $this->assertFalse($validator->validate(''));
    }

    public function testRejectsWhitespace(): void
    {
        $validator = new PrivateKeyBlockValidator();

        $this->assertFalse($validator->validate('   '));
    }

    public function testRejectsSymbols(): void
    {
        $validator = new PrivateKeyBlockValidator();

        $this->assertFalse($validator->validate('@@@'));
    }

    public function testRejectsMixedText(): void
    {
        $validator = new PrivateKeyBlockValidator();

        $this->assertFalse($validator->validate('random-text'));
    }

    public function testRejectsNewlines(): void
    {
        $validator = new PrivateKeyBlockValidator();

        $this->assertFalse($validator->validate("\n\t"));
    }

    public function testRejectsNullByte(): void
    {
        $validator = new PrivateKeyBlockValidator();

        $this->assertFalse($validator->validate("\0"));
    }
}
