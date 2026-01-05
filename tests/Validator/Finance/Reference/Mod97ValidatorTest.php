<?php

namespace Tests\Validator\Finance\Reference;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Finance\Reference\Mod97Validator;

/**
 * @internal
 */
class Mod97ValidatorTest extends TestCase
{
    public function testAcceptsValidReference(): void
    {
        $validator = new Mod97Validator();

        $this->assertTrue($validator->validate('RF47ABC123'));
    }

    public function testAcceptsSecondValidReference(): void
    {
        $validator = new Mod97Validator();

        $this->assertTrue($validator->validate('RF18123456789'));
    }

    public function testAcceptsLongerReference(): void
    {
        $validator = new Mod97Validator();

        $this->assertTrue($validator->validate('RF38PAYMENTREF'));
    }

    public function testAcceptsLowercaseReference(): void
    {
        $validator = new Mod97Validator();

        $this->assertTrue($validator->validate('rf47abc123'));
    }

    public function testRejectsInvalidChecksum(): void
    {
        $validator = new Mod97Validator();

        $this->assertFalse($validator->validate('RF00ABC123'));
    }

    public function testRejectsInvalidPrefix(): void
    {
        $validator = new Mod97Validator();

        $this->assertFalse($validator->validate('RA47ABC123'));
    }

    public function testRejectsShortReference(): void
    {
        $validator = new Mod97Validator();

        $this->assertFalse($validator->validate('RF47'));
    }

    public function testRejectsTooLongReference(): void
    {
        $validator = new Mod97Validator();

        $this->assertFalse($validator->validate('RF47ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456'));
    }

    public function testRejectsInvalidCharacters(): void
    {
        $validator = new Mod97Validator();

        $this->assertFalse($validator->validate('RF47ABC123!'));
    }

    public function testRejectsMissingDigits(): void
    {
        $validator = new Mod97Validator();

        $this->assertFalse($validator->validate('RFXXABC123'));
    }
}
