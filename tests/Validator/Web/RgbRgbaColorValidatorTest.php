<?php

namespace Tests\Validator\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Web\RgbRgbaColorValidator;

/**
 * @internal
 */
class RgbRgbaColorValidatorTest extends TestCase
{
    public function testValidRgbFunction(): void
    {
        $validator = new RgbRgbaColorValidator();

        $this->assertTrue($validator->validate('rgb(255,0,0)'));
        $this->assertTrue($validator->validate('rgb(0, 128, 255)'));
        $this->assertTrue($validator->validate('RGB( 12 , 34 , 56 )'));
    }

    public function testRejectsRgbOutOfRange(): void
    {
        $validator = new RgbRgbaColorValidator();

        $this->assertFalse($validator->validate('rgb(256,0,0)'));
        $this->assertFalse($validator->validate('rgb(0,999,0)'));
        $this->assertFalse($validator->validate('rgb(300,300,300)'));
    }

    public function testValidRgbaFunction(): void
    {
        $validator = new RgbRgbaColorValidator();

        $this->assertTrue($validator->validate('rgba(34,12,64,0.75)'));
        $this->assertTrue($validator->validate('rgba(10, 20, 30, 1)'));
        $this->assertTrue($validator->validate('RGBA(0,0,0,0)'));
        $this->assertTrue($validator->validate('rgba(1,2,3,.5)'));
        $this->assertTrue($validator->validate('rgba(1,2,3,0.0)'));
    }

    public function testRejectsInvalidAlpha(): void
    {
        $validator = new RgbRgbaColorValidator();

        $this->assertFalse($validator->validate('rgba(12,34,56,1.5)'));
        $this->assertFalse($validator->validate('rgba(12,34,56,-0.1)'));
        $this->assertFalse($validator->validate('rgba(12,34,56,abc)'));
    }

    public function testRejectsRgbaOutOfRangeChannels(): void
    {
        $validator = new RgbRgbaColorValidator();

        $this->assertFalse($validator->validate('rgba(300,0,0,0.2)'));
        $this->assertFalse($validator->validate('rgba(0,256,0,0.2)'));
        $this->assertFalse($validator->validate('rgba(0,0,999,0.2)'));
    }

    public function testValidPlainRgbTriplets(): void
    {
        $validator = new RgbRgbaColorValidator();

        $this->assertTrue($validator->validate('12,34,56'));
        $this->assertTrue($validator->validate('0, 0, 0'));
        $this->assertTrue($validator->validate('255,255,255'));
        $this->assertTrue($validator->validate('  1, 2, 3  '));
    }

    public function testRejectsInvalidPlainRgbTriplets(): void
    {
        $validator = new RgbRgbaColorValidator();

        $this->assertFalse($validator->validate('256,0,0'));
        $this->assertFalse($validator->validate('0,256,0'));
        $this->assertFalse($validator->validate('0,0,999'));
        $this->assertFalse($validator->validate('1,2'));
        $this->assertFalse($validator->validate('1,2,3,4'));
    }

    public function testRejectsCompletelyInvalidStrings(): void
    {
        $validator = new RgbRgbaColorValidator();

        $this->assertFalse($validator->validate('not a color'));
        $this->assertFalse($validator->validate('rgb()'));
        $this->assertFalse($validator->validate('rgba()'));
    }
}
