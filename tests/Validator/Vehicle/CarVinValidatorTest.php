<?php

namespace Tests\Validator\Vehicle;

use PHPUnit\Framework\TestCase;
use TextProbe\Validator\Vehicle\CarVinValidator;

/**
 * @internal
 */
class CarVinValidatorTest extends TestCase
{
    public function testValidVinWithNumericCheckDigit(): void
    {
        $validator = new CarVinValidator();

        $this->assertTrue($validator->validate('1M8GDM9AXKP042788'));
    }

    public function testValidVinWithXCheckDigit(): void
    {
        $validator = new CarVinValidator();

        $this->assertTrue($validator->validate('5GZCZ43D13S812715'));
    }

    public function testRejectsWrongLength(): void
    {
        $validator = new CarVinValidator();

        $this->assertFalse($validator->validate('1M8GDM9AXKP04278'));   // 16
        $this->assertFalse($validator->validate('1M8GDM9AXKP0427888')); // 18
    }

    public function testRejectsForbiddenLetters(): void
    {
        $validator = new CarVinValidator();

        $this->assertFalse($validator->validate('1M8GDM9AIKP042788'));
        $this->assertFalse($validator->validate('1M8GDM9AOKP042788'));
        $this->assertFalse($validator->validate('1M8GDM9AQKP042788'));
    }

    public function testRejectsInvalidCharacters(): void
    {
        $validator = new CarVinValidator();

        $this->assertFalse($validator->validate('1M8GDM9A*KP042788'));
        $this->assertFalse($validator->validate('1M8GDM9A KP042788'));
    }

    public function testRejectsInvalidCheckDigit(): void
    {
        $validator = new CarVinValidator();

        $this->assertFalse($validator->validate('1M8GDM9A1KP042788'));
    }

    public function testAcceptsLowercaseVinInput(): void
    {
        $validator = new CarVinValidator();

        $this->assertTrue($validator->validate('1m8gdm9axkp042788'));
    }
}
